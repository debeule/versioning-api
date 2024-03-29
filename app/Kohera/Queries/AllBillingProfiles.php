<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Kohera\BillingProfile;
use App\Kohera\School;
use Illuminate\Database\Eloquent\Builder;
use App\Imports\Queries\ExternalBillingProfiles;
use Illuminate\Support\Collection;

final class AllBillingProfiles implements ExternalBillingProfiles
{
    public function query(): Builder
    {
        return School::query();
    }

    public function get(): Collection
    {
        $schools = $this->query()->get();
        
        $billingProfiles = collect();

        foreach ($schools as $school) 
        {
            if (empty($school->Facturatie_Adres)) 
            {
                continue;
            }

            /** @var School $school */
            $billingProfile = new BillingProfile($school);
            $billingProfile->record_id = $school->id;
            $billingProfiles ->push($billingProfile);
        }

        return $billingProfiles;
    }
}