<?php

declare(strict_types=1);

namespace App;

use DateInterval;
use DateTimeInterface;

final class Nested
{
    /** @param array<array<DateTimeInterface|DateInterval|string>>|null $elements */
    public function __construct(public ?array $elements = null)
    {
    }
}
