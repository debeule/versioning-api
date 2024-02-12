<?php

declare(strict_types=1);

namespace App\Imports;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Schools\Commands\SyncSchoolsDomain;
use App\Sports\Commands\SyncSportsDomain;

final class SyncAllDomainsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $syncSchools = new SyncSchoolsDomain();
        $syncSchools();

        $syncSports = new SyncSportsDomain();
        $syncSports();
    }
}
