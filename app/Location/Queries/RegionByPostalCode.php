<?php

declare(strict_types=1);

namespace App\Location\Queries;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use App\Imports\Objects\Version;
use App\Location\Region;
use App\Location\Municipality;

final class RegionByPostalCode
{
    public function __construct(
        public Version $version = new Version()
    ) {}

    public function query(string $postalCode): Builder
    {
        $municipality = Municipality::where('postal_code', $postalCode)->first();
        $regionQuery = Region::query()->where('id', $municipality->region_id);

        return $this->version->versionQuery($regionQuery);
    }

    public function find(string $postalCode): ?Region
    {
        return $this->query($postalCode)->first();
    }
}