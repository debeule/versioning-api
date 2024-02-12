<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Schools\School;
use App\Schools\Province;
use App\Schools\Region;
use App\Schools\Municipality;
use App\Schools\Address;
use App\Kohera\School as KoheraSchool;
use App\Kohera\Sanitizer\Sanitizer;
use App\Kohera\Queries\AllSchools as AllKoheraSchools;

use App\Schools\Commands\CreateNewRegionCommand;
use App\Schools\Commands\CreateNewProvinceCommand;
use App\Schools\Commands\CreateNewMunicipalityCommand;
use App\Schools\Commands\CreateNewAddressCommand;
use App\Schools\Commands\CreateNewSchoolCommand;

final class SyncSchoolsTableCommand
{
    public function __invoke(): void
    {
        $existingSchools = School::all();
        $processedSports = [];

        $AllkoheraSchools = new AllKoheraSchools();
        
        foreach ($AllkoheraSchools() as $key => $koheraSchool) 
        {
            $sanitizer = new Sanitizer();
            $koheraSchool = $sanitizer->cleanAllFields($koheraSchool);
            
            if (in_array($koheraSchool->School_Id, $processedSports)) 
            {
                continue;
            }

            $existingSchool = $existingSchools->where('school_id', $koheraSchool->School_Id)->first();


            $createNewMunicipalityCommand = new CreateNewMunicipalityCommand();
            $createNewMunicipalityCommand($koheraSchool);

            $createNewAddressCommand = new CreateNewAddressCommand();
            $createNewAddressCommand($koheraSchool);

            $createNewSchoolCommand = new CreateNewSchoolCommand();
            $createNewSchoolCommand($koheraSchool);

            $existingSchools = $existingSchools->where('school_id', "!=", $koheraSchool->School_Id);
            array_push($processedSports, $koheraSchool->School_Id);
        }

        //school found in sports table but not in koheraschools
        foreach ($existingSchools as $existingSchool) 
        {
            $existingSchool->delete();
        }
    }
}