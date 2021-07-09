<?php declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

final class AkeneoFilterProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions()
    {
        return [
            new Filter('filter'),
            new Attribute('attribute'),
            new Coalesce('coalesce'),
            new Locale('locale'),
            new Scope('scope'),
            new AnyOf('anyOf'),
            new AllOf('allOf'),
            new Slice('slice'),
            new Head('head'),
            new Tail('tail'),
            new Offset('offset'),
            new First('first'),
            new Last('last'),
            new DateTime('dateTime'),
            new DateTimeZone('dateTimeZone'),
            new MetricAmount('metricAmount'),
            new MetricUnit('metricUnit'),
            new FormatMetric('formatMetric'),
            new ConvertMetric('formatMetric'),
        ];
    }
}
