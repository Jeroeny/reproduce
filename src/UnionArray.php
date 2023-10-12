<?php

declare(strict_types=1);

namespace App;

use DateInterval;
use DateTimeInterface;

final class UnionArray
{
    /** @param array<DateTimeInterface>|array<DateInterval>|null $elements */
    public function __construct(public ?array $elements = null)
    {
    }
}
