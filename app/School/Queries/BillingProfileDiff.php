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
        private AllBillingProfiles $allBillingProfilesQuery = new AllBillingProfiles,
        private ExternalBillingProfiles $externalBillingProfilesQuery,
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
