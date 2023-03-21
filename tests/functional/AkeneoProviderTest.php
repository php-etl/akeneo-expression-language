<?php

declare(strict_types=1);

namespace functional\Kiboko\Component\ExpressionLanguage\Akeneo;

use Kiboko\Component\ExpressionLanguage\Akeneo\AkeneoFilterProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Vfs\FileSystem;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversNothing]
class AkeneoProviderTest extends TestCase
{
    private $resource = null;

    protected function setUp(): void
    {
        $this->resource = \tmpfile();
    }

    protected function tearDown(): void
    {
        \fclose($this->resource);
        $this->resource = null;
    }

    public static function dataProvider()
    {
        yield 'Filter locale, filter(input, locale("fr_FR"))' => [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, locale("fr_FR"))',
        ];

        yield 'Filter inexistent locale, filter(input, locale("it_IT"))' => [
            [],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, locale("it_IT"))',
        ];

        yield 'Filter scope, filter(input, scope("print"))' => [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, scope("print"))',
        ];

        yield 'Filter inexistent scope, filter(input, scope("mobile"))' => [
            [],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, scope("mobile"))',
        ];

        yield 'Filter scope and locale, filter(input, scope("print"), locale("fr_FR"))' => [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, scope("print"), locale("fr_FR"))',
        ];

        yield 'Filter multiple locales, filter(input, locale("fr_FR", "fr_CA"))' => [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, locale("fr_FR", "fr_CA"))',
        ];

        yield 'Filter multiple scopes, filter(input, scope("web", "print"))' => [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, scope("web", "print"))',
        ];

        yield 'Filter scope or locale, filter(input, anyOf(scope("web"), locale("fr_FR")))' => [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, anyOf(scope("web"), locale("fr_FR")))',
        ];

        yield 'Filter with coalesce scope, filter(input, locale("fr_FR"), coalesce("print", "web"))' => [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, locale("fr_FR"), coalesce("print", "web"))',
        ];

        yield 'Filter with coalesce scope, filter(input, locale("fr_FR"), coalesce("web", "print"))' => [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, locale("fr_FR"), coalesce("web", "print"))',
        ];

        yield 'Slice values' => [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, slice(1, 2))',
        ];

        yield 'Head values' => [
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, head(3))',
        ];

        yield 'Tail values' => [
            [
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, tail(3))',
        ];

        yield 'First value' => [
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, first())',
        ];

        yield 'Last value' => [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, last())',
        ];

        yield 'Offset value' => [
            [
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, offset(1))',
        ];

        yield 'Filter multiple locales with ordering, filter(input, locale("fr_FR", "fr_CA", "en_US"))' => [
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_GB',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, locale("fr_FR", "fr_CA", "en_US"))',
        ];

        yield 'Filter multiple scopes with ordering, filter(input, scope("print", "mobile", "web"))' => [
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_GB',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'marketplace',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_GB',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, scope("print", "mobile", "web"))',
        ];

        yield 'Filter multiple scopes keeping first, filter(input, scope("print", "mobile", "web"), first())' => [
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'marketplace',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_GB',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, scope("print", "mobile", "web"), first())',
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProvider')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function executingFilter(array $expected, array $input, string $expression): void
    {
        $interpreter = new ExpressionLanguage(null, [new AkeneoFilterProvider()]);

        $this->assertEquals($expected, $interpreter->evaluate($expression, ['input' => $input]));
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProvider')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function compiledFilter(array $expected, array $input, string $expression): void
    {
        $interpreter = new ExpressionLanguage(null, [new AkeneoFilterProvider()]);

        fwrite($this->resource, '<?php return function(array $input) {return '.($interpreter->compile($expression, ['input'])).';};');
        $compiled = include stream_get_meta_data($this->resource)['uri'];

        $this->assertEquals($expected, $compiled($input));
    }
}
