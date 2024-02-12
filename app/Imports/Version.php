<?php

declare(strict_types=1);

namespace App\Imports;

use DateTimeImmutable;

class Version
{
    private DateTimeImmutable $version;    

    public function __construct(int $year = null, int $month = null, int $day = null)
    {
        if ($year === null || $month === null || $day === null) 
        {
            $currectDate = new DateTimeImmutable();
            
            $year = $year ?? (int) $currectDate->format('Y');
            $month = $month ?? (int) $currectDate->format('m');
            $day = $day ?? (int) $currectDate->format('d');
        }

        $dateString = sprintf('%04d-%02d-%02d', $year, $month, $day);
        $this->version = DateTimeImmutable::createFromFormat(('Y-m-d'), $dateString);
    }

    public function __invoke(): Builder
    {
        return $query
            ->orderBy('updated_at', 'desc')
            ->first();
    }

    public function __toString(): string
    {
        return $this->version->format('Y-m-d');
    }
}