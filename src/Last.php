<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class Last extends ExpressionFunction
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
        return 'function(array $input) {return array_slice($input, -1, 1, true);}';
    }

    private function evaluate(array $context): callable
    {
        return fn (array $input) => \array_slice($input, -1, 1, true);
    }
}
