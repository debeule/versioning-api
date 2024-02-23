<?php

declare(strict_types=1);

namespace App\Imports\Objects;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;

final class Version
{
    private CarbonImmutable $version;
    public function __construct() 
    {
        $this->version = CarbonImmutable::now(); 
    }

    public function __invoke($input): void
    {
        $this->version = CarbonImmutable::parse($input);
    }

    public function versionQuery(Builder $query): Builder
    {
        return $query
            ->where('created_at', '<=', $this->version)
            ->Where('deleted_at', '>=', $this->version)
            ->orWhereNull('deleted_at');
    }

    public function __toString(): string
    {
        return $this->version->format('Y-m-d');
    }
}