<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\School\Queries\SchoolDiff;
use App\School\School;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncSchools
{
    use DispatchesJobs; 

    public function __invoke(SchoolDiff $schoolDiff): void
    {
        foreach ($schoolDiff->additions() as $externalSchool) 
        {
            $this->dispatchSync(new CreateSchool($externalSchool));
        }

        foreach ($schoolDiff->deletions() as $school) 
        {
            $this->dispatchSync(new SoftDeleteSchool($school));
        }

        foreach ($schoolDiff->updates() as $externalSchool) 
        {
            $this->dispatchSync(new SoftDeleteSchool(School::where('record_id', $externalSchool->recordId())->first()));
            $this->dispatchSync(new CreateSchool($externalSchool));
        }
    }
}