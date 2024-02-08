<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Schools\School;
use App\Schools\Province;
use App\Schools\Region;
use App\Schools\Municipality;
use App\Schools\Address;
use App\Kohera\dwhSchools;

use App\Schools\Commands\CreateNewRegionCommand;
use App\Schools\Commands\CreateNewProvinceCommand;
use App\Schools\Commands\CreateNewMunicipalityCommand;
use App\Schools\Commands\CreateNewAddressCommand;
use App\Schools\Commands\CreateNewSchoolCommand;

class SyncSchoolsTable
{
    public function __invoke(): void
    {
        $existingSchools = School::all();
        
        foreach (dwhSchools::all() as $key => $dwhSchool) 
        {
            $schoolExists = $existingSchools->where('school_id', $dwhSchool->School_Id)->isNotEmpty();

            if ($schoolExists)
            {
                $existingSchools = $existingSchools->where('name', "!=", $dwhSchool->School_Id);

                continue;
            }

            if (!$schoolExists) 
            {
                $purifier = new Purifier();
                $dwhSchool = $purifier->cleanAllFields($dwhSchool);

                $createNewMunicipalityCommand = new CreateNewMunicipalityCommand();
                $createNewMunicipalityCommand($dwhSchool);

                $createNewAddressCommand = new CreateNewAddressCommand();
                $createNewAddressCommand($dwhSchool);

                $createNewSchoolCommand = new CreateNewSchoolCommand();
                $createNewSchoolCommand($dwhSchool);
            }
        }

        foreach ($existingSchools as $existingSchool) 
        {
            $existingSchool->delete();
        }
    }
}