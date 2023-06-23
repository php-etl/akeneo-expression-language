<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class WithMultipleOption extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile(string $codes, string $attribute, string $labels, string $locale = 'null', string $scope = 'null'): string
    {
        return <<<PHP
            (function() use(\$input) {
                \$linkedData = array_map(
                    function (string \$code) use(\$input) {
                        static \$labels = {$labels};

                        return [
                            'attribute' => {$attribute},
                            'code' => \$code,
                            'labels' => \$labels[\$code] ?? [],
                        ];
                    },
                    {$codes},
                );
                return [
                    [
                        'data' => ({$codes}),
                        'locale' => {$locale},
                        'scope' => {$scope},
                        'linked_data' => \$linkedData,
                    ],
                ];
            })()
            PHP;
    }

    /**
     * @return array<int, array<string, array|string|null>>
     */
    private function evaluate(array $context, array $codes, string $attribute, array $labels, string|null $locale = null, string|null $scope = null): array
    {
        return [[
            'locale' => $locale,
            'scope' => $scope,
            'data' => $codes,
            'linked_data' => array_map(
                fn (string $code) => [
                    'attribute' => $attribute,
                    'code' => $code,
                    'labels' => $labels[$code] ?? [],
                ],
                $codes
            ),
        ]];
    }
}
