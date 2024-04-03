<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Kohera\Sport;
use Illuminate\Database\Eloquent\Builder;
use App\Imports\Queries\ExternalSports;
use Illuminate\Support\Collection;

final class AllSports implements ExternalSports
{
    public function query(): Builder
    {
        return Sport::query();
    }

    public function get(): Collection
    {
        return $this->query()->get();
    }
}