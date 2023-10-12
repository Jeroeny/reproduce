<?php

declare(strict_types=1);

namespace App;

use DateInterval;
use DateTimeInterface;

final class WithNull
{
    /** @param array<DateTimeInterface|null>|null $elements */
    public function __construct(public ?array $elements = null)
    {
    }
}
