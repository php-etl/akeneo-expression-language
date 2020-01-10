<?php declare(strict_types=1);

namespace Kiboko\Component\ETL\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class First extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile()
    {
        return 'function(array $input) {return array_slice($input, 0, 1, true);}';
    }

    private function evaluate(array $context)
    {
        return function(array $input) {
            return array_slice($input, 0, 1, true);
        };
    }
}