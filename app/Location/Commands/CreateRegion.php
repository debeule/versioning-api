<?php


declare(strict_types=1);

namespace App\Location\Commands;

use App\Kohera\Region as KoheraRegion;
use App\Location\Region;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class CreateRegion
{
    use DispatchesJobs;

    public function __construct(
        public KoheraRegion $koheraRegion
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->koheraRegion)->save();
    }

    public function buildRecord(KoheraRegion $koheraRegion): Region
    {
        $newRegion = new Region();

        $newRegion->name = $koheraRegion->name();
        $newRegion->record_id = $koheraRegion->recordId();
        $newRegion->region_number = $koheraRegion->regionNumber();
        
        return $newRegion;
    }
}