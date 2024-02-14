<?php

declare(strict_types=1);

namespace App\Imports\Objects;

use CarbonImmutable;
use Illuminate\Database\Query\Builder;

final class Version
{
    private CarbonImmutable $version;    

    public function __invoke($input)
    {
        $this->version = CarbonImmutable::parse($input);
    }

    public function versionQuery(): Builder
    {
        return $query
            ->where('updated_at', '>=', (string)$this)
            ->orderBy('version', 'asc')
            ->first();
    }

    public function __toString(): string
    {
        return $this->version->format('Y-m-d');
    }
}