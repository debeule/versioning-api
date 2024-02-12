<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Kohera\Region;

final class AllRegions
{
    public function __invoke(): Object
    {
        # TODO : api call to get dwhregions
        return Region::all();
    }
}