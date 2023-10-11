<?php

declare(strict_types=1);

namespace App;

use DateInterval;
use DateTimeInterface;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;

final class Xml
{
    public function __construct(public Uuid|null $element = null)
    {
    }
}
