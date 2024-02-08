<?php

namespace App\Kohera\Queries;

use App\Kohera\DwhRegion;

final class GetAllDwhRegionsQuery
{
    public function __invoke(): Object
    {
        # TODO : api call to get regions
        return DwhRegion::all();
    }
}