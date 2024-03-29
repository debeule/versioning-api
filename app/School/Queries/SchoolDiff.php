<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\Services\FilterAdditions;
use App\Services\FilterDeletions;
use App\Services\FilterUpdates;
use App\School\Queries\AllSchools;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Imports\Queries\ExternalSchools;
use Illuminate\Support\Collection;

final class SchoolDiff
{
    use DispatchesJobs;

    public function __construct(
        private AllSchools $allSchools = new AllSchools,
        private ExternalSchools $externalSchools,
    ) {}

    public function externalSchools(ExternalSchools $externalSchools): self
    {
        return new self($this->allSchools, $externalSchools);
    }

    public function additions(): Collection
    {
        return $this->DispatchSync(new FilterAdditions($this->allSchools->get(), $this->externalSchools->get()));
    }

    public function deletions(): Collection
    {
        return $this->DispatchSync(new FilterDeletions($this->allSchools->get(), $this->externalSchools->get()));
    }

    public function updates(): Collection
    {
        return $this->DispatchSync(new FilterUpdates($this->allSchools->get(), $this->externalSchools->get()));
    }
}
