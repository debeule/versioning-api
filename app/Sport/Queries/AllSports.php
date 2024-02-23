<?php

declare(strict_types=1);

namespace App\Sport\Queries;

use Illuminate\Database\Eloquent\Builder;
use App\Sport\Sport;
use App\Imports\Objects\Version;

final class AllSports
{
    public function __construct(
        public Version $version = new Version()
    ) {}

    public function query(): Builder
    {
        return $this->version->versionQuery(Sport::query());
    }

    public function get(): Object
    {
        return $this->query()->get();
    }
}