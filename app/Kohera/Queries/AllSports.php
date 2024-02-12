<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Kohera\Sport;

final class AllSports
{
    public function __invoke(): Object
    {
        # TODO : api call to get dwhsports
        return Sport::all();
    }
}