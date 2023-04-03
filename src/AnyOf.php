<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class AnyOf extends ExpressionFunction
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
        $pattern = <<<'COMPILED'
            function (array $input) {
                return %s;
            }
            COMPILED;

        $compiled = array_map(fn ($item) => sprintf('(%s)($input)', $item), $filters);

        return sprintf($pattern, implode(' + ', array_reverse($compiled, false)));
    }

    private function evaluate(array $context, callable ...$filters): callable
    {
        return function (array $input) use ($filters) {
            $output = [];
            foreach ($filters as $filter) {
                $output = $filter($input) + $output;
            }

            return $output;
        };
    }
}
