<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Kohera\Region;
use Illuminate\Database\Eloquent\Builder;
use App\Imports\Queries\ExternalRegions;
use Illuminate\Support\Collection;

final class AllRegions implements ExternalRegions
{
    public function query(): Builder
    {
        return Region::query();
    }

    # TODO: not used anywhere?
    public function get(): Collection
    {
        return $this->query()->get()->unique('RegioDetailId');
    }

    public function getWithDoubles(): Collection
    {
        return $this->query()->get();
    }
}