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

    public function query(string $name): Builder
    {
        $regionQuery = Region::query()->where('name', '=', $name);

        return $this->version->versionQuery($regionQuery);
    }

    public function find(string $name): ?Region
    {
        return $this->query($name)->first();
    }
}