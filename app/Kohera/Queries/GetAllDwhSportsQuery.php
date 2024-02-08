<?php

namespace App\Kohera\Queries;

use App\Kohera\DwhSport;

final class GetAllDwhSportsQuery
{
    public function __invoke(): Object
    {
        # TODO : api call to get sports
        return DwhSport::all();
    }
}