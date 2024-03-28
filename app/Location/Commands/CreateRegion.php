<?php


declare(strict_types=1);

namespace App\Location\Commands;

use App\Imports\Queries\Region
use App\Location\Region;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class CreateRegion
{
    use DispatchesJobs;

    public function __construct(
        public Region $region
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->region)->save();
    }

    public function buildRecord(Region $region): Region
    {
        $newRegion = new Region();

        $newRegion->name = $region->name();
        $newRegion->record_id = $region->recordId();
        $newRegion->region_number = $region->regionNumber();
        
        return $newRegion;
    }
}