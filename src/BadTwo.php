<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Uid\Uuid;

class BadTwo
{
    private bool $create = false;

    private bool $delete = false;

    private Uuid $id;

    private string $foo = 'foo';

    public function __construct(Uuid $id)
    {
        $this->id = $id;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getCreate(): bool
    {
        return $this->create;
    }

    private function getDelete(): bool
    {
        return $this->delete;
    }

    public function create(): self
    {
        $this->create = true;

        return $this;
    }

    protected function delete(): self
    {
        $this->delete = true;

        return $this;
    }
}
