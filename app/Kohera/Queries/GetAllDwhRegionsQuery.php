<?php

namespace App\Kohera\Queries;

use Illuminate\Support\Facades\DB;

final class GetAllDwhRegionsQuery
{
    public function __invoke()
    {
        # TODO: External API call
        return DB::connection('sqlite')->table('SNS-Regio')->get();
    }
}
