<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\Imports\Queries\ExternalBillingProfiles;
use App\Services\FilterAdditions;
use App\Services\FilterDeletions;
use App\Services\FilterUpdates;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;

final class BillingProfileDiff
{
    use DispatchesJobs;

    private Collection $allBillingProfiles;
    private Collection $externalBillingProfiles;

    public function __construct(
        private AllBillingProfiles $allBillingProfilesQuery = new AllBillingProfiles,
        private ?ExternalBillingProfiles $externalBillingProfilesQuery = null,
    ) {
        $this->allBillingProfiles = $this->allBillingProfilesQuery->get();
        $this->externalBillingProfiles = $this->externalBillingProfilesQuery->get();
    }

    public function externalBillingProfiles(ExternalBillingProfiles $externalBillingProfilesQuery): self
    {
        return new self($this->allBillingProfilesQuery, $externalBillingProfilesQuery);
    }

    public function additions(): Collection
    {
        return $this->DispatchSync(new FilterAdditions($this->allBillingProfiles, $this->externalBillingProfiles));
    }

    public function deletions(): Collection
    {
        return $this->DispatchSync(new FilterDeletions($this->allBillingProfiles, $this->externalBillingProfiles));
    }

    public function updates(): Collection
    {
        return $this->DispatchSync(new FilterUpdates($this->allBillingProfiles, $this->externalBillingProfiles));
    }
}
