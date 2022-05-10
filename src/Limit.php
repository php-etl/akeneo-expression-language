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
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(string ...$filters)
    {
        $compiled = array_map(fn ($item) => sprintf('(%s)($item)', $item), $filters);

        return sprintf('function(array $input) {return array_filter($input, function ($item) {return %s;});}', implode(' && ', $compiled));
    }

    private function evaluate(array $context, callable ...$filters)
    {
        return function (array $input) use ($filters) {
            return \array_slice(
                $input,
                ...array_map(fn (callable $filter) => $filter($input), $filters)
            );
        };
    }
}
