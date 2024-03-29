<?php

declare(strict_types=1);

namespace App\Sport\Queries;

use App\Services\FilterAdditions;
use App\Services\FilterDeletions;
use App\Services\FilterUpdates;
use App\Sport\Queries\AllSports;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Imports\Queries\ExternalSports;
use Illuminate\Support\Collection;

final class SportDiff
{
    use DispatchesJobs;

    public function __construct(
        private AllSports $allSports = new AllSports,
        private ExternalSports $externalSports,
    ) {}

    public function externalSports(ExternalSports $externalSports): self
    {
        return new self($this->allSports, $externalSports);
    }

    public function additions(): Collection
    {
        return $this->DispatchSync(new FilterAdditions($this->allSports->get(), $this->externalSports->get()));
    }

    public function deletions(): Collection
    {
        return $this->DispatchSync(new FilterDeletions($this->allSports->get(), $this->externalSports->get()));
    }

    public function updates(): Collection
    {
        return $this->DispatchSync(new FilterUpdates($this->allSports->get(), $this->externalSports->get()));
    }
}
