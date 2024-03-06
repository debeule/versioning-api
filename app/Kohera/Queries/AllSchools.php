<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Kohera\School;
use Illuminate\Database\Eloquent\Builder;

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