<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class WithReferenceEntityValue extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile(string $value, string $locale = 'null', string $channel = 'null'): string
    {
        return sprintf('([["data" => (%s), "locale" => (%s), "channel" => (%s)]])', $value, $locale, $channel);
    }

    private function evaluate(array $context, string $value, string|null $locale = null, string|null $channel = null): array
    {
        return [[
            'locale' => $locale,
            'channel' => $channel,
            'data' => $value,
        ]];
    }
}
