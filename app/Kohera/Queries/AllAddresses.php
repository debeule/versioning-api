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
            $address = new Address($school);
            $addresses ->push($address);
        }

        return $addresses;
    }
}