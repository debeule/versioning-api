<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\School\Queries\SchoolDiff;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Imports\Queries\ExternalMunicipalities;

final class SyncSchools
{
    use DispatchesJobs;

    public function __invoke(SchoolDiff $schoolDiff): void
    {
        foreach ($schoolDiff->additions() as $koheraSchool) 
        {
            $this->dispatchSync(new CreateSchool($koheraSchool));
        }

        foreach ($schoolDiff->deletions() as $school) 
        {
            $this->dispatchSync(new SoftDeleteSchool($school));
        }

        foreach ($schoolDiff->updates() as $koheraSchool) 
        {
            $this->dispatchSync(new SoftDeleteSchool(School::where('record_id', $koheraSchool->recordId())->first()));
            $this->dispatchSync(new CreateSchool($koheraSchool));
        }
    }
}