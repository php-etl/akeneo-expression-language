<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class Build extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile(string ...$values): string
    {
        return sprintf('array_values(array_merge(%s))', implode(', ', $values));
    }

    private function evaluate(array $context, array ...$values): array
    {
        return array_values(array_merge(...$values));
    }
}
