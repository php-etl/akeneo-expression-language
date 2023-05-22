<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class WithValue extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(string $value, string $locale = 'null', string $scope = 'null')
    {
        return sprintf('([["data" => (%s), "locale" => (%s), "scope" => (%s)]])', $value, $locale, $scope);
    }

    private function evaluate(array $context, string $value, ?string $locale = null, ?string $scope = null)
    {
        return [[
            'locale' => $locale,
            'scope' => $scope,
            'data' => $value,
        ]];
    }
}
