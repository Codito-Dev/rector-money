<?php

declare(strict_types=1);

namespace Rector\Money\Rule;

use Money\Currency;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Type\ObjectType;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class CurrencyAvailableWithinToCurrenciesContainsRector extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Changes the way how currency is verified against collection',
            [
                new CodeSample(
                    '$currency->isAvailableWithin($currencies);',
                    '$currencies->contains($currency);'
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

        return $this->nodeFactory->createMethodCall($node->getArgs()[0]->value, 'contains', [$node->var]);
    }

    private function shouldSkip(MethodCall $node): bool
    {
        /** @var ObjectType $executedOn */
        $executedOn = $this->nodeTypeResolver->getNativeType($node->var);

        return $executedOn->getClassName() !== Currency::class
            || $this->nodeNameResolver->getName($node->name) !== 'isAvailableWithin';
    }
}
