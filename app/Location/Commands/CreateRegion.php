<?php 

declare(strict_types=1);

namespace App\Location\Commands;

use App\Location\Region;
use App\Kohera\Region as KoheraRegion;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Location\Municipality;

final class CreateRegion
{
    use DispatchesJobs;

    public function __construct(
        public KoheraRegion $koheraRegion
    ) {}

    public function handle(): bool
    {
        if (!$this->recordExists($this->koheraRegion)) 
        {
            return $this->buildRecord($this->koheraRegion);
        }

        if ($this->recordExists($this->koheraRegion) && $this->recordHasChanged($this->koheraRegion)) 
        {
            return $this->createNewRecordVersion($this->koheraRegion);
        }

        return true;
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
        
        $newRegion->save();

        return $this->linkMunicipalitiesToRegion($koheraRegion);
    }

    public function recordHasChanged(KoheraRegion $koheraRegion): bool
    {
        $region = Region::where('region_id', $koheraRegion->regionId())->first();

        $recordhasChanged = false;

        $recordhasChanged = $recordhasChanged || $region->name !== $koheraRegion->name();
        $recordhasChanged = $recordhasChanged || $region->region_number !== $koheraRegion->regionNumber();

        return $recordhasChanged;
    }

    public function createNewRecordVersion(KoheraRegion $koheraRegion): bool
    {
        Region::where('region_id', $koheraRegion->regionId())->delete();

        return $this->buildRecord($koheraRegion);
    }

    public function linkMunicipalitiesToRegion($koheraRegion)
    {
        //link municipalities to region
        $municipalities = Municipality::where('postal_code', $koheraRegion->postalCode())->get();
    
        foreach ($municipalities as $municipality) 
        {
            $municipality->region_id = $koheraRegion->regionId();
            $municipality->save();
        }
        
        return true;
    }
}