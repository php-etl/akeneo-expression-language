<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class WithProductValueMediaFile extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile(string $code, string $attribute, string $locale = 'null', string $scope = 'null'): string
    {
        return <<<PHP
            [
                'identifier' => {$code},
                'attribute' => {$attribute},
                'locale' => {$locale},
                'scope' => {$scope},
            ]
            PHP;
    }

    /**
     * @return array<string, string>
     */
    private function evaluate(array $context, string $code, string $attribute, ?string $locale = null, ?string $scope = null): array
    {
        return [
            'identifier' => $code,
            'attribute' => $attribute,
            'locale' => $locale,
            'scope' => $scope,
        ];
    }
}
