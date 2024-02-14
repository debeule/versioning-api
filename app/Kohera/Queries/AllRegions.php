<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use Illuminate\Database\Eloquent\Builder;
use App\Kohera\Region;

final class AllRegions
{
    public function query(): Builder
    {
        return Region::query()
            ->select([
                'RegionNaam AS name',
                'Provincie AS province',
                'Postcode AS postal_code',
                'RegioDetailId AS region_id'
            ]);
    }

    public function get(): Object
    {
        return $this->query()->get();
    }
}