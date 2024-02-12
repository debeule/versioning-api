<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Kohera\School;

final class AllSchools
{
    public function __invoke(): Object
    {
        # TODO : api call to get dwhschools
        return School::all();
    }
}