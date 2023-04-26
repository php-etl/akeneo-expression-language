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

    private function compile(string $input, string ...$callbacks)
    {
        $output = sprintf('%s ?? []', $input);
        foreach ($callbacks as $callback) {
            $output = sprintf('(%s)(%s)', $callback, $output);
        }

        return sprintf('array_values(%s)', $output);
    }

    private function evaluate(array $context, Value ...$values)
    {
        $output = [];
        foreach ($values as $value) {
            $output[] = $value->asArray();
        }

        return array_values($output);
    }
}
