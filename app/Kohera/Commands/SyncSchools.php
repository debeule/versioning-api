<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\School\Commands\CreateSchool;
use App\School\Commands\SoftDeleteSchool;
use App\School\School;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Kohera\Queries\AllSchools as AllKoheraSchools;
use App\School\Queries\AllSchools;

use App\Services\ProcessImportedRecords;

final class SyncSchools
{
    use DispatchesJobs;

    public function __construct(
        private AllKoheraSchools $allKoheraSchools = new AllKoheraSchools(),
        private AllSchools $allSchools = new AllSchools()
    ) {}
        

    public function __invoke(): void
    {
        $result = ProcessImportedRecords::setup($this->allKoheraSchools->get(), $this->allSchools->get())->pipe();
        
        foreach ($result['update'] as $School) 
        {
            $this->dispatchSync(new SoftDeleteSchool(School::where('record_id', $koheraSchool->recordId())->first()));
            $this->dispatchSync(new CreateSchool($School));
        }

        foreach ($result['create'] as $koheraSchool) 
        {
            $this->dispatchSync(new CreateSchool($koheraSchool));
        }

        foreach ($result['delete'] as $koheraSchool) 
        {
            $this->dispatchSync(new SoftDeleteSchool($koheraSchool));
        }
    }
}