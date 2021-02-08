<?php declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class Coalesce extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(string ...$scopes)
    {
        $pattern =<<<"PATTERN"
function (array \$input): array {
    \$output = array_filter(\$input, function(array \$item) {
        return in_array(\$item['scope'], [%1\$s]);
    });
    
    usort(\$output, function(array \$left, array \$right) {
        \$leftIndex = array_search(\$left['scope'], [%1\$s]);
        \$rightIndex = array_search(\$right['scope'], [%1\$s]);

        if (\$leftIndex === \$rightIndex) {
            return 0;
        }
        if (false === \$rightIndex) {
            return -1;
        }
        if (false === \$leftIndex) {
            return 1;
        }

        return \$leftIndex <=> \$rightIndex;
    });

    return \$output;
}
PATTERN;

        return sprintf($pattern, implode(', ', $scopes));
    }

    private function evaluate(array $context, string ...$scopes)
    {
        return function (array $input) use($scopes): array {
            $output = array_filter($input, function(array $item) use($scopes) {
                return in_array($item['scope'], $scopes);
            });

            usort($output, function(array $left, array $right) use($scopes) {
                $leftIndex = array_search($left['scope'], $scopes);
                $rightIndex = array_search($right['scope'], $scopes);

                if ($leftIndex === $rightIndex) {
                    return 0;
                }
                if (false === $rightIndex) {
                    return -1;
                }
                if (false === $leftIndex) {
                    return 1;
                }

                return $leftIndex <=> $rightIndex;
            });

            return $output;
        };
    }
}
