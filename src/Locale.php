<?php declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class Locale extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(string ...$locales)
    {
        $pattern =<<<"PATTERN"
function (array \$input): array {
    \$output = array_filter(\$input, function(array \$item) {
        return in_array(\$item['locale'], [%s]);
    });

    return \$output;
}
PATTERN;

        return sprintf($pattern, implode(', ', $locales));
    }

    private function evaluate(array $context, ?string ...$locales)
    {
        return function (array $input) use ($locales): array {
            $output = array_filter($input, function (array $item) use ($locales) {
                return in_array($item['locale'], $locales);
            });

            return $output;
        };
    }
}
