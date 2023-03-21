<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class Scope extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable($this->compile(...))->bindTo($this),
            \Closure::fromCallable($this->evaluate(...))->bindTo($this)
        );
    }

    private function compile(string ...$scopes): string
    {
        $pattern = <<<'PATTERN'
            function (array $input): array {
                $output = array_filter($input, function(array $item) {
                    return in_array($item['scope'], [%s]);
                });

                return $output;
            }
            PATTERN;

        return sprintf($pattern, implode(', ', $scopes));
    }

    private function evaluate(array $context, string ...$scopes): callable
    {
        return fn (array $input): array => array_filter($input, fn (array $item) => \in_array($item['scope'], $scopes));
    }
}
