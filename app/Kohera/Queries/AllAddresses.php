<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Kohera\School;
use App\Kohera\Address;

final class AllAddresses
{
    public function query(): Builder
    {
        return School::query();
    }

    public function get(): Object
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
            
            $address = new Address($school);
            $address->address_id = 'billing_profile-' . $school->id;
            $school->address = $school->Facturatie_Adres;
            $school->Gemeente = $school->Facturatie_Gemeente;
            $school->PostCode = $school->Facturatie_Postcode;

            $addresses ->push($address);
        }

        return $addresses;
    }
}