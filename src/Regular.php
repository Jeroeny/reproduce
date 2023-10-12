<?php

declare(strict_types=1);

namespace App;

use DateInterval;
use DateTimeInterface;

final class Regular
{
    /** @param DateTimeInterface[] $elements */
    public function __construct(public array $elements = [])
    {
    }
}
