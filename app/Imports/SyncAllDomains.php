<?php

declare(strict_types=1);

namespace App\Imports;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\School\Commands\SyncSchoolDomain;
use App\Sport\Commands\SyncSportDomain;
use App\Location\Commands\SyncLocationDomain;

final class SyncAllDomains implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $syncLocations = new SyncLocationDomain();
        $syncLocations();

        $syncSchools = new SyncSchoolDomain();
        $syncSchools();

        $syncSports = new SyncSportDomain();
        $syncSports();
    }
}
