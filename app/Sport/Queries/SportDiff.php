<?php

declare(strict_types=1);

namespace App\Sport\Queries;

use App\Imports\Queries\ExternalSports;
use App\Services\FilterAdditions;
use App\Services\FilterDeletions;
use App\Services\FilterUpdates;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;

final class SportDiff
{
    use DispatchesJobs;

    public function __construct(
        private AllSports $allSportsQuery = new AllSports,
        private ExternalSports $externalSportsQuery,
    ) {
        $this->allSports = $this->allSportsQuery->get();
        $this->externalSports = $this->externalSportsQuery->get();
    }

    public function externalSports(ExternalSports $externalSportsQuery): self
    {
        return new self($this->allSportsQuery, $externalSportsQuery);
    }

    public function additions(): Collection
    {
        return $this->DispatchSync(new FilterAdditions($this->allSports, $this->externalSports));
    }

    public function deletions(): Collection
    {
        return $this->DispatchSync(new FilterDeletions($this->allSports, $this->externalSports));
    }

    public function updates(): Collection
    {
        return $this->DispatchSync(new FilterUpdates($this->allSports, $this->externalSports));
    }
}
