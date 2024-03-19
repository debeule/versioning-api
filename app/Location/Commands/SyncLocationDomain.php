<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Bpost\Commands\SyncMunicipalities;
use App\Kohera\Commands\SyncRegions;

final class SyncLocationDomain
{
    public function __invoke(): void
    {
        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();

        $syncRegions = new SyncRegions();
        $syncRegions();
    }
}