<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use Illuminate\Database\Eloquent\Builder;
use App\Kohera\School;
use App\Kohera\BillingProfile;

final class AllBillingProfiles
{
    public function query(): Builder
    {
        return School::query();
    }

    public function get(): Object
    {
        $schools = $this->query()->get();
        
        $billingProfiles = collect();

        foreach ($schools as $school) 
        {
            $billingProfile = new BillingProfile($school);
            $billingProfile->billing_profile_id = $school->id;
            $billingProfiles ->push($billingProfile);
        }

        return $billingProfiles;
    }
}