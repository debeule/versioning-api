<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Kohera\Address;
use App\Kohera\School;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Imports\Queries\ExternalAddresses;

final class AllAddresses implements ExternalAddresses
{
    public function query(): Builder
    {
        return School::query();
    }

    public function get(): Collection
    {
        $schools = $this->query()->get();
        
        $addresses = collect();

        foreach ($schools as $school) 
        {
            /** @var School $school */
            $address = new Address($school);
            $address->record_id = 'school-' . $school->id;
            $addresses ->push($address);

            //billing_profile address
            if (empty($school->Facturatie_Adres)) 
            {
                continue;
            }
            
            $schoolClone = clone($school);

            $schoolClone->address = $school->Facturatie_Adres;
            $schoolClone->Gemeente = $school->Facturatie_Gemeente;
            $schoolClone->Postcode = $school->Facturatie_Postcode;

            $billingProfileAddress = new Address($schoolClone);
            $billingProfileAddress->record_id = 'billing_profile-' . $schoolClone->id;

            $addresses->push($billingProfileAddress);
        }

        return $addresses;
    }
}