<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\School\School;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use App\Imports\Objects\Version;

final class SchoolByInstitutionId
{
    public function __construct(
        public Version $version = new Version()
    ) {}

    public function query(string $institutionId): Builder
    {
        $schoolQuery = School::query()->where('institution_id', '=', $institutionId);

        return $this->version->versionQuery($schoolQuery);
    }

    public function find(string $name): ?School
    {
        return $this->query($name)->first();
    }
}