<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class MetricUnit extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(string $value): string
    {
        return <<<"PATTERN"
            !is_array({$value}) || !array_key_exists('unit', {$value}) ? null : {$value}['unit']
            PATTERN;
    }

    private function evaluate(array $context, array $value): string
    {
        return !\is_array($value) || !\array_key_exists('unit', $value) ? null : $value['unit'];
    }
}
