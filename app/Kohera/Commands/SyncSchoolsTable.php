<?php

declare(strict_types=1);

namespace App\Kohera\commands;

use App\School\School;
use App\School\Province;
use App\School\Region;
use App\School\Municipality;
use App\School\Address;
use App\Kohera\School as KoheraSchool;
use App\Kohera\Sanitizer\Sanitizer;
use App\Kohera\Queries\AllSchools as AllKoheraSchools;
use App\School\Commands\CreateRegion;
use App\School\Commands\CreateMunicipality;
use App\School\Commands\CreateAddress;
use App\School\Commands\CreateSchool;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class SyncSchoolsTable
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $existingSchools = School::all();
        $processedSchools = [];

        $AllkoheraSchools = new AllKoheraSchools();
        
        foreach ($AllkoheraSchools() as $key => $koheraSchool) 
        {
            $sanitizer = new Sanitizer();
            $koheraSchool = $sanitizer->cleanAllFields($koheraSchool);
            
            if (in_array($koheraSchool->School_Id, $processedSchools)) 
            {
                continue;
            }

            $this->dispatchSync(new CreateSchool($koheraSchool));

            $existingSchools = $existingSchools->where('school_id', "!=", $koheraSchool->School_Id);
            array_push($processedSchools, $koheraSchool->School_Id);
        }

        //school found in sports table but not in koheraschools
        foreach ($existingSchools as $existingSchool) 
        {
            $existingSchool->delete();
        }
    }
}