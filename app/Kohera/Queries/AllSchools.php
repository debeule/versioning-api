<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Kohera\School;
use Illuminate\Database\Eloquent\Builder;
use App\Imports\Queries\ExternalSchools;
use Illuminate\Support\Collection;

final class AllSchools implements ExternalSchools
{
    public function query(): Builder
    {
        return School::query();
    }

    public function get(): Collection
    {
        return $this->query()->get();
    }
}