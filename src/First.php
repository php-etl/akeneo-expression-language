<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class First extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile(): string
    {
        return <<<'PHP'
            (function($array){
                return [\reset($array)];
            })
            PHP;
    }

    private function evaluate(array $context): callable
    {
        return fn ($array) => [reset($array)];
    }
}
