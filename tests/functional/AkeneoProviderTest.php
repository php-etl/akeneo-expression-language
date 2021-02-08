<?php

namespace functional\Kiboko\Component\ExpressionLanguage\Akeneo;

use Kiboko\Component\ExpressionLanguage\Akeneo\AkeneoFilterProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Vfs\FileSystem;

class AkeneoProviderTest extends TestCase
{
private ?FileSystem $fs = null;

    protected function setUp(): void
    {
        $this->fs = FileSystem::factory('vfs://');
        $this->fs->mount();
    }

    protected function tearDown(): void
    {
        $this->fs->unmount();
        $this->fs = null;
    }

    public function dataProvider()
    {
        yield [
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
            'akeneo\\filter(input, akeneo\\locale("fr_FR"))',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\locale("it_IT"))',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\scope("print"))',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\scope("mobile"))',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\scope("print"), akeneo\\locale("fr_FR"))',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\locale("fr_FR", "fr_CA"))',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\scope("web", "print"))',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\anyOf(akeneo\\scope("web"), akeneo\\locale("fr_FR")))',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\locale("fr_FR"), akeneo\\coalesce("print", "web"))',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\locale("fr_FR"), akeneo\\coalesce("web", "print"))',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\slice(1, 2))',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\head(3))',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\tail(3))',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\first())',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\last())',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\offset(1))',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\locale("fr_FR", "fr_CA", "en_US"))',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\scope("print", "mobile", "web"))',
        ];

        yield [
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
            'akeneo\\filter(input, akeneo\\scope("print", "mobile", "web"), akeneo\\first())',
        ];
    }

    /**
     * @param array $expected
     * @param array $input
     * @param string $expression
     *
     * @dataProvider dataProvider
     */
    public function testExecutingFilter(array $expected, array $input, string $expression)
    {
        $interpreter = new ExpressionLanguage(null, [new AkeneoFilterProvider()]);

        $this->assertEquals($expected, $interpreter->evaluate($expression, ['input' => $input]));
    }

    /**
     * @param array $expected
     * @param array $input
     * @param string $expression
     *
     * @dataProvider dataProvider
     */
    public function testCompiledFilter(array $expected, array $input, string $expression)
    {
        $interpreter = new ExpressionLanguage(null, [new AkeneoFilterProvider()]);

        $filename =  'vfs://' . hash('sha512', random_bytes(512)) . '.php';
        file_put_contents($filename, '<?php return function(array $input) {return ' . ($interpreter->compile($expression, ['input'])) . ';};');
        $compiled = include $filename;

        $this->assertEquals($expected, $compiled($input));
    }
}
