<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Imports\Queries\ExternalRegions;
use App\Kohera\Region;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final class AllRegions implements ExternalRegions
{
    public function query(): Builder
    {
        return Region::query();
    }

    public function get(): Collection
    {
        return $this->query()->get()->unique('RegioDetailId');
    }

    public function getWithDoubles(): Collection
    {
        return $this->query()->get();
    }
}