<?php

namespace App\Kohera\Queries;

use App\Kohera\DwhSchool;

final class GetAllDwhSchoolsQuery
{
    public function __invoke(): Object
    {
        # TODO : api call to get schools
        return DwhSchool::all();
    }
}