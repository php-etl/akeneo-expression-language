<?php declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

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

    private function compile($array)
    {
        return <<<"PHP"
            (function(\$array){
                return reset(\$array);
            })($array)
PHP;
    }

    private function evaluate(array $context, $array)
    {
        return (function ($array) {
            return reset($array);
        })($array);
    }
}
