<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Kohera\Queries\AllSports as AllKoheraSports;
use App\Services\ProcessImportedRecords;
use App\Sport\Commands\CreateSport;
use App\Sport\Commands\SoftDeleteSport;

use App\Sport\Queries\AllSports;
use App\Sport\Sport;

use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncSports
{
    use DispatchesJobs;

    public function __construct(
        private AllKoheraSports $allKoheraSports = new AllKoheraSports(),
        private AllSports $allSports = new AllSports()
    ) {}
        

    public function __invoke(): void
    {
        $result = ProcessImportedRecords::setup($this->allKoheraSports->get(), $this->allSports->get())->pipe();

        foreach ($result['update'] as $koheraSport) 
        {
            $this->dispatchSync(new SoftDeleteSport(Sport::where('record_id', $koheraSport->recordId())->first()));
            $this->dispatchSync(new CreateSport($koheraSport));
        }

        foreach ($result['create'] as $koheraSport) 
        {
            $this->dispatchSync(new CreateSport($koheraSport));
        }

        foreach ($result['delete'] as $sport) 
        {
            $this->dispatchSync(new SoftDeleteSport($sport));
        }
    }
}