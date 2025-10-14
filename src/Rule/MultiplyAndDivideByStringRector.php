<?php

declare(strict_types=1);

namespace Codito\Rector\Money\Rule;

use InvalidArgumentException;
use Money\Money;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\Float_;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\MutatingScope;
use PHPStan\Type\ObjectType;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class MultiplyAndDivideByStringRector extends AbstractRector implements ConfigurableRectorInterface
{
    public const PRECISION = 'precision';

    private int $precision;

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Changes the way how money is multiplied / divided',
            [
                new CodeSample(
                    'Money::PLN(100)->multiply(2.5);',
                    'Money::PLN(100)->multiply(\'2.5\');'
                ),
                new CodeSample(
                    'Money::PLN(100)->divide($floatDivider);',
                    'Money::PLN(100)->divide(sprintf(\'%.5F\', $floatDivider));'
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [MethodCall::class];
    }

    /**
     * @param MethodCall $node
     */
    public function refactor(Node $node): ?Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }

        $args = $node->getArgs();
        $firstArg = $args[0];
        $firstArgValue = $firstArg->value;

        // Refactor passing float as an explicit argument
        if ($firstArgValue instanceof Float_) {
            $firstArg->value = new String_((string)$firstArgValue->value);

            return $node;
        }

        $scope = $node->getAttribute(AttributeKey::SCOPE);

        if ($scope instanceof MutatingScope && (
            ( // Refactor passing float by variable
                $firstArgValue instanceof Variable
                && ($firstArgName = $this->nodeNameResolver->getName($firstArgValue->name)) !== null
                && $scope->getVariableType($firstArgName)->isFloat()->yes()
            )
            || ( // Refactor passing float by function/method return type
                (
                    $firstArgValue instanceof FuncCall
                    || $firstArgValue instanceof MethodCall
                    || $firstArgValue instanceof StaticCall
                )
                && $this->isFloatReturned($firstArgValue, $scope)
            )
        )) {
            $this->wrapWithSprintf($firstArg);

            return $node;
        }

        return null;
    }

    public function configure(array $configuration): void
    {
        $precision = $configuration[self::PRECISION] ?? 5;

        if ($precision !== null && !is_int($precision)) { // @phpstan-ignore-line
            throw new InvalidArgumentException(sprintf('"%s" must be an integer or null', self::PRECISION));
        }

        $this->precision = $precision;
    }

    private function shouldSkip(MethodCall $node): bool
    {
        $executedOn = $this->nodeTypeResolver->getType($node->var);

        return !$executedOn instanceof ObjectType
            || $executedOn->getClassName() !== Money::class
            || !$node->name instanceof Identifier
            || !in_array($node->name->toLowerString(), ['divide', 'multiply'], true);
    }

    private function wrapWithSprintf(Arg $arg): void
    {
        $arg->value = $this->nodeFactory->createFuncCall(
            'sprintf',
            [
                sprintf('%%.%dF', $this->precision),
                $arg->value,
            ]
        );
    }

    /**
     * @param FuncCall|MethodCall|StaticCall $node
     */
    private function isFloatReturned(CallLike $node, MutatingScope $scope): bool
    {
        $type = $scope->getType($node);

        return $type->isFloat()->yes();
    }
}
