<?php

declare(strict_types=1);

namespace App\Sport\Commands;

use App\Sport\Queries\SportDiff;
use App\Sport\Sport;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncSports
{
    use DispatchesJobs;

    public function __invoke(SportDiff $sportDiff): void
    {
        foreach ($sportDiff->additions() as $externalSport) 
        {
            $this->dispatchSync(new CreateSport($externalSport));
        }

        foreach ($sportDiff->deletions() as $sport) 
        {
            $this->dispatchSync(new SoftDeleteSport($sport));
        }

        foreach ($sportDiff->updates() as $externalSport) 
        {
            $this->dispatchSync(new SoftDeleteSport(Sport::where('record_id', $externalSport->recordId())->first()));
            $this->dispatchSync(new CreateSport($externalSport));
        }
    }
}