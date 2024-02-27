<?php

declare(strict_types=1);

namespace App\Location\Queries;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Imports\Values\Version;
use App\Location\Region;
use App\Location\Municipality;

final class AllLinkedMunicipalities
{
    public function __construct(
        public Version $version = new Version()
    ) {}

    public function query(int $regionNumber): Builder
    {
        $region = Region::where('region_number', $regionNumber)->first();
        
        $municipalityQuery = Municipality::query()->where('region_id', $region->id);

        return $this->version->versionQuery($municipalityQuery);
    }

    public function get(int $regionNumber): Collection
    {
        return $this->query($regionNumber)->get();
    }
}