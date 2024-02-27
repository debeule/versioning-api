<?php

declare(strict_types=1);

namespace App\Imports\Values;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;

final class Version
{
    # TODO: make private
    public CarbonImmutable $version;
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
            ->whereDate('created_at', '<=', (string) $this->version)
            ->where(function ($query) {
                $query->WhereNull('deleted_at')
                    ->orWhereDate('deleted_at', '>', $this->version);
                    
            });
    }

    public function __toString(): string
    {
        return $this->version->format('Y-m-d');
    }
}