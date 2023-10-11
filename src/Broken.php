<?php

declare(strict_types=1);

namespace App;

use DateInterval;
use DateTimeInterface;

final class Broken
{
    public function __construct(public DateInterval|DateTimeInterface|null $elements = null)
    {
    }
}
