<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class MetricAmount extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile(string $value, int $decimalRound = 4): string
    {
        return <<<PATTERN
            !is_array({$value}) || !array_key_exists('amount', {$value}) ? null : round(floatval({$value}['amount']), {$decimalRound})
            PATTERN;
    }

    private function evaluate(array $context, array $value, int $decimalRound): float|null
    {
        return !\is_array($value) || !\array_key_exists('amount', $value) ? null : round((float) $value['amount'], $decimalRound);
    }
}
