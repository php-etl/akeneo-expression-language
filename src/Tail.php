<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class Tail extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile(string $length): string
    {
        return sprintf('function(array $input) {return array_slice($input, -%s, %s, true);}', $length, $length);
    }

    private function evaluate(array $context, int $length): callable
    {
        return fn (array $input) => \array_slice($input, -$length, $length, true);
    }
}
