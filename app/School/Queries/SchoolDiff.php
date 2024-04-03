<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\Imports\Queries\ExternalSchools;
use App\Services\FilterAdditions;
use App\Services\FilterDeletions;
use App\Services\FilterUpdates;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;

final class SchoolDiff
{
    use DispatchesJobs;

    public function __construct(
        private AllSchools $allSchoolsQuery = new AllSchools,
        private ExternalSchools $externalSchoolsQuery,
    ) {
        $this->allSchools = $this->allSchoolsQuery->get();
        $this->externalSchools = $this->externalSchoolsQuery->get();
    }

    public function externalSchools(ExternalSchools $externalSchoolsQuery): self
    {
        return new self($this->allSchoolsQuery, $externalSchoolsQuery);
    }

    public function additions(): Collection
    {
        return $this->DispatchSync(new FilterAdditions($this->allSchools, $this->externalSchools));
    }

    public function deletions(): Collection
    {
        return $this->DispatchSync(new FilterDeletions($this->allSchools, $this->externalSchools));
    }

    public function updates(): Collection
    {
        return $this->DispatchSync(new FilterUpdates($this->allSchools, $this->externalSchools));
    }
}
