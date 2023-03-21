<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class Slice extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable($this->compile(...))->bindTo($this),
            \Closure::fromCallable($this->evaluate(...))->bindTo($this)
        );
    }

    private function compile(string $offset, string $length): string
    {
        return sprintf('function(array $input) {return array_slice($input, %s, %s, true);}', $offset, $length);
    }

    private function evaluate(array $context, int $offset, int $length): callable
    {
        return fn (array $input) => \array_slice($input, $offset, $length, true);
    }
}
