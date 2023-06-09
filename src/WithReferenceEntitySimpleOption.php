<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class WithReferenceEntitySimpleOption extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile(string $code, string $locale = 'null', string $channel = 'null'): string
    {
        return <<<PHP
            ([
                [
                    'data' => [
                        {$code}
                    ],
                    'locale' => {$locale},
                    'channel' => {$channel},
                ],
            ])
            PHP;
    }

    private function evaluate(array $context, string $code, string $locale = null, string $channel = null): array
    {
        return [[
            'locale' => $locale,
            'channel' => $channel,
            'data' => [
                $code,
            ],
        ]];
    }
}
