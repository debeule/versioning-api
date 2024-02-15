<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use Illuminate\Database\Eloquent\Builder;
use App\Kohera\Region;

final class AllRegions
{
    public function query(): Builder
    {
        return Region::query();
    }

    public function get(): Object
    {
        return $this->query()->get();
    }
}