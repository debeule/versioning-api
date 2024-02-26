<?php

declare(strict_types=1);

namespace App\School\Queries;

use Illuminate\Database\Eloquent\Builder;
use App\School\School;
use App\Imports\Objects\Version;

final class AllSchools
{
    public function __construct(
        public Version $version = new Version()
    ) {}

    public function query(): Builder
    {
        return $this->version->versionQuery(School::query());
    }

    public function get(): Object
    {
        return $this->query()->get();
    }
}