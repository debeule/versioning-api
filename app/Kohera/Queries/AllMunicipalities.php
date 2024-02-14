<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Kohera\School;

final class AllMunicipalities
{
    public function query(): Builder
    {
        return School::query()
            ->select([
                'Gemeente AS name',
                'Postcode AS postal_code',
            ]);
    }

    public function get(): Object
    {
        return $this->query()->get();
    }
}