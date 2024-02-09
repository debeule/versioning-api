<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Schools\School;
use App\Schools\Province;
use App\Schools\Region;
use App\Schools\Municipality;
use App\Schools\Address;
use App\Kohera\DwhSchool;
use App\Kohera\Purifier\Purifier;
use App\Kohera\Queries\GetAllDwhSchoolsQuery;

use App\Schools\Commands\CreateNewRegionCommand;
use App\Schools\Commands\CreateNewProvinceCommand;
use App\Schools\Commands\CreateNewMunicipalityCommand;
use App\Schools\Commands\CreateNewAddressCommand;
use App\Schools\Commands\CreateNewSchoolCommand;

class SyncSchoolsTableCommand
{
    public function __invoke(): void
    {
        $existingSchools = School::all();
        $processedSports = [];

        $getAllDwhSchoolsQuery = new GetAllDwhSchoolsQuery();
        
        foreach ($getAllDwhSchoolsQuery() as $key => $dwhSchool) 
        {
            $purifier = new Purifier();
            $dwhSchool = $purifier->cleanAllFields($dwhSchool);
            
            if (in_array($dwhSchool->School_Id, $processedSports)) 
            {
                continue;
            }

            $existingSchool = $existingSchools->where('school_id', $dwhSchool->School_Id)->first();


            $createNewMunicipalityCommand = new CreateNewMunicipalityCommand();
            $createNewMunicipalityCommand($dwhSchool);

            $createNewAddressCommand = new CreateNewAddressCommand();
            $createNewAddressCommand($dwhSchool);

            $createNewSchoolCommand = new CreateNewSchoolCommand();
            $createNewSchoolCommand($dwhSchool);

            $existingSchools = $existingSchools->where('school_id', "!=", $dwhSchool->School_Id);
            array_push($processedSports, $dwhSchool->School_Id);
        }

        //school found in sports table but not in dwhschools
        foreach ($existingSchools as $existingSchool) 
        {
            $existingSchool->delete();
        }
    }
}