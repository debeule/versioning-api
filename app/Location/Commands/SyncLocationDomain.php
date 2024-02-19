<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Kohera\Commands\SyncRegions;
use App\Bpost\Commands\SyncMunicipalities;

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