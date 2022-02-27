<?php

declare(strict_types=1);

namespace Rector\Money\Rule;

use Money\Money;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\DNumber;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\MutatingScope;
use PHPStan\Type\FloatType;
use PHPStan\Type\ObjectType;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class MultiplyAndDivideByStringRector extends AbstractRector
{
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
        if ($firstArgValue instanceof DNumber) {
            $firstArg->value = new String_((string)$firstArgValue->value);

            return $node;
        }

        // Refactor passing float by variable
        $scope = $node->getAttribute(AttributeKey::SCOPE);

        if ($firstArgValue instanceof Variable
            && ($firstArgName = $this->nodeNameResolver->getName($firstArgValue->name)) !== null
            && $scope instanceof MutatingScope
        ) {
            $firstArgType = $scope->getVariableType($firstArgName);

            if ($firstArgType instanceof FloatType) {
                $firstArg->value = $this->nodeFactory->createFuncCall(
                    'sprintf',
                    [
                        '%.5F',
                        $firstArgValue,
                    ]
                );

                return $node;
            }
        }

        return null;
    }

    private function shouldSkip(MethodCall $node): bool
    {
        /** @var ObjectType $executedOn */
        $executedOn = $this->nodeTypeResolver->getNativeType($node->var);

        return $executedOn->getClassName() !== Money::class
            || !$node->name instanceof Identifier
            || !in_array($node->name->toLowerString(), ['divide', 'multiply'], true);
    }
}
