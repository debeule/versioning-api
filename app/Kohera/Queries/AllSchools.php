<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Kohera\School;

final class AllSchools
{
    public function query(): Builder
    {
        return School::query();
    }

    public function get(): Object
    {
        return $this->query()->get();
    }
}