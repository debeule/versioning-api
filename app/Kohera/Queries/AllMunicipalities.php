<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Kohera\School;
use App\Kohera\Municipality;

final class AllMunicipalities
{
    public function query(): Builder
    {
        return School::query();
    }

    public function get(): Object
    {
        $schools = $this->query()->get();

        $municipalities = collect();

        foreach ($schools as $school) 
        {
            $municipality = new Municipality($school);
            $municipalities ->push($municipality);
        }

        return $municipalities;
    }
}