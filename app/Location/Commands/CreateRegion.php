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
        if (! $this->recordExists($this->koheraRegion)) 
        {
            return $this->buildRecord($this->koheraRegion);
        }

        if ($this->recordHasChanged($this->koheraRegion)) 
        {
            return $this->createNewRecordVersion($this->koheraRegion);
        }

        return false;
    }

    private function recordExists(KoheraRegion $koheraRegion): bool
    {
        return Region::where('region_id', $koheraRegion->regionId())->exists();
    }

    public function buildRecord(KoheraRegion $koheraRegion): bool
    {
        $newRegion = new Region();

        $newRegion->name = $koheraRegion->name();
        $newRegion->region_id = $koheraRegion->regionId();
        $newRegion->region_number = $koheraRegion->regionNumber();
        
        return $newRegion->save();
    }

    public function recordHasChanged(KoheraRegion $koheraRegion): bool
    {
        $region = Region::where('region_id', $koheraRegion->regionId())->first();

        $recordhasChanged = false;

        $recordhasChanged = $region->name !== $koheraRegion->name();
        $recordhasChanged = $recordhasChanged || $region->region_number !== $koheraRegion->regionNumber();

        return $recordhasChanged;
    }

    public function createNewRecordVersion(KoheraRegion $koheraRegion): bool
    {
        Region::where('region_id', $koheraRegion->regionId())->delete();

        return $this->buildRecord($koheraRegion);
    }
}