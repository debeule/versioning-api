<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Kohera\DwhRegion;

final class GetAllDwhRegionsQuery
{
    public function __invoke(): Object
    {
        # TODO : api call to get dwhregions
        return DwhRegion::all();
    }
}