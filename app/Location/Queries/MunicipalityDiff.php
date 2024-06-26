<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Imports\Queries\ExternalMunicipalities;
use App\Services\FilterAdditions;
use App\Services\FilterDeletions;
use App\Services\FilterUpdates;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;

final class MunicipalityDiff
{
    use DispatchesJobs;

    private Collection $allMunicipalities;
    private Collection $externalMunicipalities;

    public function __construct(
        private AllMunicipalities $allMunicipalitiesQuery = new AllMunicipalities,
        private ?ExternalMunicipalities $externalMunicipalitiesQuery = null,
    ) {
        $this->allMunicipalities = $this->allMunicipalitiesQuery->get();
        $this->externalMunicipalities = $this->externalMunicipalitiesQuery->get();
    }

    public function externalMunicipalities(ExternalMunicipalities $externalMunicipalitiesQuery): self
    {
        return new self($this->allMunicipalitiesQuery, $externalMunicipalitiesQuery);
    }

    public function additions(): Collection
    {
        return $this->DispatchSync(new FilterAdditions($this->allMunicipalities, $this->externalMunicipalities));
    }

    public function deletions(): Collection
    {
        return $this->DispatchSync(new FilterDeletions($this->allMunicipalities, $this->externalMunicipalities));
    }

    public function updates(): Collection
    {
        return $this->DispatchSync(new FilterUpdates($this->allMunicipalities, $this->externalMunicipalities));
    }
}