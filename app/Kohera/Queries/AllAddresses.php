<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Kohera\School;

final class AllAddresses
{
    public function query(): Builder
    {
        return School::query()
            ->select([
                DB::raw("SUBSTR(address, INSTR(address, ' ') + 1) AS street_identifier"),
                DB::raw("SUBSTR(address, 1, INSTR(address, ' ') - 1) AS street_name"),
                'Postcode AS postal_code',
            ]);
    }

    public function get(): Object
    {
        return $this->query()->get();
    }
}