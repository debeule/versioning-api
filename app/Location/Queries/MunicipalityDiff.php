<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Services\FilterAdditions;
use App\Services\FilterDeletions;
use App\Services\FilterUpdates;
use App\Location\Queries\AllMunicipalities;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Imports\Queries\ExternalMunicipalities;
use Illuminate\Support\Collection;

final class MunicipalityDiff
{
    use DispatchesJobs;

    public function __construct(
        private AllMunicipalities $allMunicipalitiesQuery = new AllMunicipalities,
        private ExternalMunicipalities $externalMunicipalitiesQuery,
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
