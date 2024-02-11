<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Kohera\DwhSchool;

final class GetAllDwhSchoolsQuery
{
    public function __invoke(): Object
    {
        # TODO : api call to get dwhschools
        return DwhSchool::all();
    }
}