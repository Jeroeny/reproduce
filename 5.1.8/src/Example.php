<?php

declare(strict_types=1);

namespace App;

final class Example
{
    /** @var string */
    private $foo;

    public function __construct(string $foo)
    {
        $this->foo = $foo;
    }
}
