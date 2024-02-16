<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\School\School;
use App\School\Province;
use App\School\Region;
use App\School\Address;
use App\Kohera\School as KoheraSchool;
use App\Imports\Sanitizer\Sanitizer;
use App\Kohera\Queries\AllSchools as AllKoheraSchools;
use App\School\Commands\CreateRegion;
use App\School\Commands\CreateAddress;
use App\School\Commands\CreateSchool;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class SyncBillingProfiles
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $existingBillingProfiles = School::all();
        $processedBillingProfiles = [];

        $allkoheraBillingProfiles = new AllkoheraBillingProfiles();
        
        foreach ($allkoheraBillingProfiles->get() as $koheraBillingProfile) 
        {
            if (in_array($koheraBillingProfile->billingProfileId(), $processedBillingProfiles)) 
            {
                continue;
            }

            $this->dispatchSync(new CreateBillingProfile($koheraBillingProfile));

            $existingBillingProfiles = $existingBillingProfiles->where('billing_profile_id', "!=", $koheraBillingProfile->billingProfileId());

            array_push($processedBillingProfiles, $koheraBillingProfile->billingProfileId());
        }

        //billingProfile found in billing_profiles table but not in koheraBillingProfiles
        foreach ($existingBillingProfiles as $existingBillingProfile) 
        {
            $existingBillingProfile->delete();
        }
    }
}