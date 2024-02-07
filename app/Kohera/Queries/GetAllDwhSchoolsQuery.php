<?php

namespace App\Kohera\Queries;

use Illuminate\Support\Facades\DB;

final class GetAllDwhSchoolsQuery
{
    public function __invoke()
    {
        # TODO: External API call
        return DB::connection('sqlite')->table('SNS-School')->get();
    }
}
