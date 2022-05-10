<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class DateTimeZone extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(string $date, string $zone, ?string $format = null)
    {
        if (null === $format) {
            return sprintf('new \DateTimeImmutable(%s, new \DateTimeZone(%s))', $date, $zone);
        }

        return sprintf('\DateTimeImmutable::createFromFormat(%s, %s, new \DateTimeZone(%s))', $date, $format, $zone);
    }

    private function evaluate(array $context, string $date, string $zone, ?string $format = null)
    {
        if (null === $format) {
            return new \DateTimeImmutable($date, new \DateTimeZone($zone));
        }

        return \DateTimeImmutable::createFromFormat($date, $format, new \DateTimeZone($zone));
    }
}
