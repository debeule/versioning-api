<?php

declare(strict_types=1);

namespace App\Location\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncLocationDomain
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $this->DispatchSync(new SyncMunicipalities);
        $this->DispatchSync(new SyncRegionLinks);
        $this->DispatchSync(new SyncRegions);
    }
}