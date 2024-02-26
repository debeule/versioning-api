<?php

declare(strict_types=1);

namespace App\Location\Queries;

use Illuminate\Database\Eloquent\Builder;
use App\Location\Region;
use App\Imports\Objects\Version;

final class AllRegions
{
    public function __construct(
        public Version $version = new Version()
    ) {}

    public function query(): Builder
    {
        return $this->version->versionQuery(Region::query());
    }

    public function get(): Object
    {
        return $this->query()->get();
    }
}