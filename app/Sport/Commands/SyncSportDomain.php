<?php

declare(strict_types=1);

namespace App\Sport\Commands;

use App\Sport\Commands\SyncSports;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncSportDomain
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $this->DispatchSync(new SyncSports);
    }
}
