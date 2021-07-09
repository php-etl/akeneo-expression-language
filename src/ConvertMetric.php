<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

class ConvertMetric extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile($attribut)
    {
        return <<<"PHP"
            (function () use (\$input) {
            \$attribut = $attribut;
            return !(is_array(\$attribut)
            && array_key_exists('amount', \$attribut)
            && array_key_exists('unit', \$attribut)) ? null : (function (\$attribut) {
                if (\$attribut['unit'] !== 'MILLIMETER') {
                    return \$attribut;
                }

                return [
                    'unit' => 'CENTIMETER',
                    'amount' => \$attribut['amount'] / 10
                ];
            })(
                \$attribut
            );
        })()
PHP;
    }

    private function evaluate(array $context, array $attribut)
    {
        return (function () use ($input) {
            $attribut = $attribut;
            return (is_array($attribut)
                && array_key_exists('amount', $attribut)
                && array_key_exists('unit', $attribut)) ? null : (function ($attribut) {
                if ($attribut['unit'] !== 'MILLIMETER') {
                    return $attribut;
                }

                return [
                    'unit' => 'CENTIMETER',
                    'amount' => $attribut['amount'] / 10
                ];
            })(
                $attribut
            );
        })();
    }
}
