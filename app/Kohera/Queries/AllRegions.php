<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Kohera\Region;
use Illuminate\Database\Eloquent\Builder;

final class AllRegions
{
    public function query(): Builder
    {
        return Region::query();
    }

    public function get(): Object
    {
        $records = $this->query()->unique('RegioDetailId')->get();
    }

    public function getWithDoubles()
    {
        return $this->query()->get();
    }
}