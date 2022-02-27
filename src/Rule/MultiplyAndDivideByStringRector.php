<?php

declare(strict_types=1);

namespace Rector\Money\Rule;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use Rector\Core\Rector\AbstractRector;
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
        return null;
    }
}
