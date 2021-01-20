<?php declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

final class AkeneoFilterProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions()
    {
        return [
            new Filter('filter'),
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
            new DateTime('datetime'),
            new DateTimeZone('datetimezone'),
//            new ExpressionFunction(
//                'coalesce',
//                function () {
//                    $filters = \func_get_args();
//                    $compiled = array_map(function ($item) {
//                        return sprintf('(%s)($item)', $item);
//                    }, $filters);
//
//                    return sprintf('function ($item) {return %s;}', implode(' || ', $compiled));
//                },
//                function (array $context, callable ...$filters) {
//                    return function ($item) use ($filters) {
//                        foreach ($filters as $filter) {
//                            if ($filter($item) === true) {
//                                return true;
//                            }
//                        }
//                        return false;
//                    };
//                }
//            ),
        ];
    }
}
