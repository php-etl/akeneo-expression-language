<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

final class AkeneoBuilderProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions(): array
    {
        return [
            new Build('build'),
            new WithValue('withValue'),
        ];
    }
}
