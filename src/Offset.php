<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class Offset extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile(string $offset): string
    {
        return sprintf('function(array $input) {return array_slice($input, %s, null, true);}', $offset);
    }

    private function evaluate(array $context, int $offset): callable
    {
        return fn (array $input) => \array_slice($input, $offset, null, true);
    }
}
