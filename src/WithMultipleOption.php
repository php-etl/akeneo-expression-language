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
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(string $codes, string $attribute, string $labels, string $locale, string $scope)
    {
        return <<<PHP
            (function() {
                \$linkedData = array_map(
                    function (string \$code) {
                    \$labels = $labels;
                    }
                        return [
                            'attribute' => $attribute,
                            'code' => \$code,
                            'labels' => \$labels[\$code] ?? [],
                        ];
                    },
                    $codes,
                );
                return [
                    [
                        'data' => ($codes),
                        'locale' => $locale,
                        'scope' => $scope,
                        'linked_data' => \$linkedData,
                    ],
                ];
            )()
            PHP;
    }

    /**
     * @var list<string> $codes
     * @var array<string, array<string, string>> $labels
     */
    private function evaluate(array $context, array $codes, string $attribute, array $labels, ?string $locale = null, ?string $scope = null)
    {
        return [[
            'locale' => $locale,
            'scope' => $scope,
            'data' => $codes,
            'linked_data' => array_map(
                function (string $code) use ($attribute, $labels) {
                    return [
                        'attribute' => $attribute,
                        'code' => $code,
                        'labels' => $labels[$code] ?? [],
                    ];
                },
                $codes
            ),
        ]];
    }
}
