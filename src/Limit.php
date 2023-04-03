<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class Limit extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile(string ...$filters): string
    {
        $compiled = array_map(fn ($item) => sprintf('(%s)($item)', $item), $filters);

        return sprintf('function(array $input) {return array_filter($input, function ($item) {return %s;});}', implode(' && ', $compiled));
    }

    private function evaluate(array $context, callable ...$filters): callable
    {
        return fn (array $input) => \array_slice(
            $input,
            ...array_map(fn (callable $filter) => $filter($input), $filters)
        );
    }
}
