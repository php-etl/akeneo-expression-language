<?php

declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

class TimestampToDate extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile($timeStamp)
    {
        return <<<"PHP"
            (function () {
            return \DateTime::createFromFormat('U',$timeStamp)->format('Y-m-d H:i:s');
        })()
PHP;
    }

    private function evaluate(array $context, string $timeStamp)
    {
        return (function () {
            return \DateTime::createFromFormat('U',$timeStamp)->format('Y-m-d H:i:s');
        })();
    }
}
