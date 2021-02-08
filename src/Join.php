<?php declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class Join extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(string $value, $glue = '","')
    {
        return sprintf('(implode(%s, (array) %s))', $glue, $value);
    }

    private function evaluate(array $context, $input, string $glue)
    {
        return implode($glue, $input);
    }
}
