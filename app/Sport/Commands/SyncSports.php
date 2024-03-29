<?php

declare(strict_types=1);

namespace App\Sport\Commands;

use App\Sport\Queries\SportDiff;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Imports\Queries\ExternalMunicipalities;

final class SyncSports
{
    use DispatchesJobs;

    public function __invoke(SportDiff $sportDiff): void
    {
        foreach ($sportDiff->additions() as $koheraSport) 
        {
            $this->dispatchSync(new CreateSport($koheraSport));
        }

        foreach ($sportDiff->deletions() as $sport) 
        {
            $this->dispatchSync(new SoftDeleteSport($sport));
        }

        foreach ($sportDiff->updates() as $koheraSport) 
        {
            $this->dispatchSync(new SoftDeleteSport(Sport::where('record_id', $koheraSport->recordId())->first()));
            $this->dispatchSync(new CreateSport($koheraSport));
        }
    }
}