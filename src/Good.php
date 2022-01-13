<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Uid\Uuid;

abstract class Good
{
    #[Ignore]
    private bool $create = false;

    #[Ignore]
    private bool $delete = false;

    private Uuid $id;

    public function __construct(Uuid $id)
    {
        $this->id = $id;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function shouldCreateAggregate(): bool
    {
        return $this->create;
    }

    public function shouldDeleteAggregate(): bool
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
