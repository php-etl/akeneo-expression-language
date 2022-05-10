<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class DateTime extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(string $date, ?string $format = null): string
    {
        if (null === $format) {
            return sprintf('new \DateTimeImmutable(%s, new \DateTimeZone("UTC"))', $date);
        }

        return sprintf('\DateTimeImmutable::createFromFormat(%s, %s, new \DateTimeZone("UTC"))', $date, $format);
    }

    private function evaluate(array $context, string $date, ?string $format = null): \DateTimeInterface
    {
        if (null === $format) {
            return new \DateTimeImmutable($date, new \DateTimeZone('UTC'));
        }

        return \DateTimeImmutable::createFromFormat($date, $format, new \DateTimeZone('UTC'));
    }
}
