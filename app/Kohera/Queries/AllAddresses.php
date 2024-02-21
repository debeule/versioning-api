<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Kohera\School;
use App\Kohera\Address;
use Illuminate\Support\Collection;

final class AllAddresses
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
            //school address
            $address = new Address($school);
            $address->address_id = 'school-' . $school->id;
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
            $billingProfileAddress->address_id = 'billing_profile-' . $schoolClone->id;

            $addresses->push($billingProfileAddress);
        }

        return $addresses;
    }
}