<?php declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

final class AkeneoFilterProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions()
    {
        return [
            new Filter('akeneo\\filter'),
            new Attribute('akeneo\\attribute'),
            new Coalesce('akeneo\\coalesce'),
            new Locale('akeneo\\locale'),
            new Scope('akeneo\\scope'),
            new AnyOf('akeneo\\anyOf'),
            new AllOf('akeneo\\allOf'),
            new Slice('akeneo\\slice'),
            new Head('akeneo\\head'),
            new Tail('akeneo\\tail'),
            new Offset('akeneo\\offset'),
            new First('akeneo\\first'),
            new Last('akeneo\\last'),
            new DateTime('akeneo\\dateTime'),
            new DateTimeZone('akeneo\\dateTimeZone'),
        ];
    }
}
