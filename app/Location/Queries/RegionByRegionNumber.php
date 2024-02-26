<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Location\Region;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use App\Imports\Objects\Version;

final class RegionByRegionNumber
{
    public function __construct(
        public Version $version = new Version()
    ) {}

    public function query(int $regionNumber): Builder
    {
        $regionQuery = Region::query()->where('region_number', '=', $regionNumber);

        return $this->version->versionQuery($regionQuery);
    }

    public function find(int $regionNumber): ?Region
    {
        return $this->query($regionNumber)->first();
    }
}