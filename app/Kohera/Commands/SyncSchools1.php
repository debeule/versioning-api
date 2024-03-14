<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Kohera\Queries\AllSchools as AllKoheraSchools;
use App\School\Commands\CreateSchool;
use App\School\School;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class SyncSchools
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $existingSchools = School::all();
        $processedSchools = [];

        $allkoheraSchools = new AllKoheraSchools();
        
        foreach ($allkoheraSchools->get() as $koheraSchool) 
        {
            if (in_array($koheraSchool->recordId(), $processedSchools)) 
            {
                continue;
            }

            $this->dispatchSync(new CreateSchool($koheraSchool));

            $existingSchools = $existingSchools->where('record_id', "!=", $koheraSchool->recordId());

            array_push($processedSchools, $koheraSchool->recordId());
        }

        //school found in sports table but not in koheraschools
        foreach ($existingSchools as $existingSchool) 
        {
            $existingSchool->delete();
        }
    }
}