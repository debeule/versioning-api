<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Kohera\Sport;
use Illuminate\Database\Eloquent\Builder;

final class AllSports
{
    public function query(): Builder
    {
        return Sport::query();
    }

    public function get(): Object
    {
        return $this->query()->get();
    }
}