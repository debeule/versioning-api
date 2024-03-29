<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\Services\FilterAdditions;
use App\Services\FilterDeletions;
use App\Services\FilterUpdates;
use App\School\Queries\AllBillingProfiles;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Imports\Queries\ExternalBillingProfiles;
use Illuminate\Support\Collection;

final class BillingProfileDiff
{
    use DispatchesJobs;

    public function __construct(
        private AllBillingProfiles $allBillingProfiles = new AllBillingProfiles,
        private ExternalBillingProfiles $externalBillingProfiles,
    ) {}

    public function externalBillingProfiles(ExternalBillingProfiles $externalBillingProfiles): self
    {
        return new self($this->allBillingProfiles, $externalBillingProfiles);
    }

    public function additions(): Collection
    {
        return $this->DispatchSync(new FilterAdditions($this->allBillingProfiles->get(), $this->externalBillingProfiles->get()));
    }

    public function deletions(): Collection
    {
        return $this->DispatchSync(new FilterDeletions($this->allBillingProfiles->get(), $this->externalBillingProfiles->get()));
    }

    public function updates(): Collection
    {
        return $this->DispatchSync(new FilterUpdates($this->allBillingProfiles->get(), $this->externalBillingProfiles->get()));
    }
}
