<?php declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class Head extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(string $length)
    {
        return sprintf('function(array $input) {return array_slice($input, 0, %s, true);}', $length);
    }

    private function evaluate(array $context, int $length)
    {
        return function (array $input) use ($length) {
            return array_slice($input, 0, $length, true);
        };
    }
}
