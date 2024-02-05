<?php

namespace App\Models\ValueObjects;

use DateTimeImmutable;

class VersionObject
{
    private DateTimeImmutable $version;    

    public function __construct(int $year, int $month = 1, int $day = 1)
    {
        $dateString = sprintf('%04d-%02d-%02d', $year, $month, $day);
        $this->version = DateTimeImmutable::createFromFormat(('Y-m-d'), $dateString);
    }

    public function __toString(): string
    {
        return $this->version->format('Y-M-D');
    }
}