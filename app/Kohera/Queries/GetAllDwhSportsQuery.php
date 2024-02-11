<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Kohera\DwhSport;

final class GetAllDwhSportsQuery
{
    public function __invoke(): Object
    {
        # TODO : api call to get dwhsports
        return DwhSport::all();
    }
}