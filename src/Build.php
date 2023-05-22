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
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(string $input, string ...$values)
    {
        return sprintf('array_values(array_merge(%s))', implode(', ', $values));
    }

    private function evaluate(array $context, array ...$values)
    {
        return array_values(array_merge(...$values));
    }
}
