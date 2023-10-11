<?php

declare(strict_types=1);

namespace App;

use DateInterval;
use DateTimeInterface;

final class Working
{
    public function __construct(public DateTimeInterface|DateInterval|null $elements = null)
    {
    }
}
