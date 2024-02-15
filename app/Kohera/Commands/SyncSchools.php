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


final class SyncSchools
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $existingSchools = School::all();
        $processedSchools = [];

        $AllkoheraSchools = new AllKoheraSchools();
        
        foreach ($AllkoheraSchools->get() as $koheraSchool) 
        {
            if (in_array($koheraSchool->schoolNumber(), $processedSchools)) 
            {
                continue;
            }

            $this->dispatchSync(new CreateSchool($koheraSchool));

            $existingSchools = $existingSchools->where('school_id', "!=", $koheraSchool->schoolNumber());

            array_push($processedSchools, $koheraSchool->schoolNumber());
        }

        //school found in sports table but not in koheraschools
        foreach ($existingSchools as $existingSchool) 
        {
            $existingSchool->delete();
        }
    }
}