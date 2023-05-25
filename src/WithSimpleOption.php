<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class WithSimpleOption extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile(string $code, string $attribute, string $labels, string $locale = 'null', string $scope = 'null'): string
    {
        return <<<PHP
            ([
                [
                    'data' => ({$code}),
                    'locale' => {$locale},
                    'scope' => {$scope},
                    'linked_data' => [
                        'attribute' => ({$attribute}),
                        'code' => ({$code}),
                        'labels' => ({$labels}),
                    ],
                ],
            ])
            PHP;
    }

    /**
     * @return array<int, array<string, array<string, array|string>|string|null>>
     */
    private function evaluate(array $context, string $code, string $attribute, array $labels, ?string $locale = null, ?string $scope = null): array
    {
        return [[
            'locale' => $locale,
            'scope' => $scope,
            'data' => $code,
            'linked_data' => [
                'attribute' => $attribute,
                'code' => $code,
                'labels' => $labels,
            ],
        ]];
    }
}
