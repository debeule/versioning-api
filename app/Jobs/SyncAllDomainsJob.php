<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Schools\Commands\SyncSchoolsDomainCommand;
use App\Sports\Commands\SyncSportsDomainCommand;

final class SyncAllDomainsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $syncSchools = new SyncSchoolsDomainCommand();
        $syncSchools();

        $syncSports = new SyncSportsDomainCommand();
        $syncSports();
    }
}
