<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\School\Queries\BillingProfileDiff;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\School\BillingProfile;

final class SyncBillingProfiles
{
    use DispatchesJobs;

    public function __invoke(BillingProfileDiff $billingProfileDiff): void
    {
        foreach ($billingProfileDiff->additions() as $koheraBillingProfile) 
        {
            $this->dispatchSync(new CreateBillingProfile($koheraBillingProfile));
        }

        foreach ($billingProfileDiff->deletions() as $billingProfile) 
        {
            $this->dispatchSync(new SoftDeleteBillingProfile($billingProfile));
        }

        foreach ($billingProfileDiff->updates() as $koheraBillingProfile) 
        {
            $this->dispatchSync(new SoftDeleteBillingProfile(BillingProfile::where('record_id', $koheraBillingProfile->recordId())->first()));
            $this->dispatchSync(new CreateBillingProfile($koheraBillingProfile));
        }
    }
}