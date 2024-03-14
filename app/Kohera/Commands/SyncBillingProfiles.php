<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Kohera\Queries\AllBillingProfiles as AllKoheraBillingProfiles;
use App\School\BillingProfile;
use App\School\Commands\CreateBillingProfile;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class SyncBillingProfiles
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $existingBillingProfiles = BillingProfile::all();
        $processedBillingProfiles = [];

        $allkoheraBillingProfiles = new AllKoheraBillingProfiles();
        
        foreach ($allkoheraBillingProfiles->get() as $koheraBillingProfile) 
        {
            if (in_array($koheraBillingProfile->recordId(), $processedBillingProfiles)) 
            {
                continue;
            }

            $this->dispatchSync(new CreateBillingProfile($koheraBillingProfile));

            $existingBillingProfiles = $existingBillingProfiles->where('record_id', "!=", $koheraBillingProfile->recordId());

            array_push($processedBillingProfiles, $koheraBillingProfile->recordId());
        }

        //billingProfile found in billing_profiles table but not in koheraBillingProfiles
        foreach ($existingBillingProfiles as $existingBillingProfile) 
        {
            $existingBillingProfile->delete();
        }
    }
}