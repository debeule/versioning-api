<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Location\Region;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use App\Imports\Objects\Version;

final class RegionByName
{
    public function __construct(
        public Version $version = new Version()
    ) {}

    public function query(string $regionNumber): Builder
    {
        $region = Region::where('region_number', $regionNumber);
        $municipalityQuery = Municipality::query()->where('region_id', $region->id);

        return $this->version->versionQuery($municipalityQuery);
    }

    public function find(string $postalCode): ?Region
    {
        return $this->query($postalCode)->first();
    }
}