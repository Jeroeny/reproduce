<?php

namespace App;

use Symfony\Component\Uid\Uuid;

final class GoodOne extends Good
{
    private string $foo;

    public function __construct(Uuid $id)
    {
        parent::__construct($id);
        $this->foo = 'foo';
    }

    public function getFoo(): string
    {
        return $this->foo;
    }
}