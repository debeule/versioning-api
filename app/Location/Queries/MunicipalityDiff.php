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
        private AllMunicipalities $allMunicipalities = new AllMunicipalities,
        private ExternalMunicipalities $externalMunicipalities,
    ) {}

    public function externalMunicipalities(ExternalMunicipalities $externalMunicipalities): self
    {
        return new self($this->allMunicipalities, $externalMunicipalities);
    }

    public function additions(): Collection
    {
        return $this->DispatchSync(new FilterAdditions($this->allMunicipalities->get(), $this->externalMunicipalities->get()));
    }

    public function deletions(): Collection
    {
        return $this->DispatchSync(new FilterDeletions($this->allMunicipalities->get(), $this->externalMunicipalities->get()));
    }

    public function updates(): Collection
    {
        return $this->DispatchSync(new FilterUpdates($this->allMunicipalities->get(), $this->externalMunicipalities->get()));
    }
}
