<?php 

declare(strict_types=1);

namespace App\Location\Commands;

use App\Location\Region;
use App\Location\Municipality;
use App\Kohera\Region as KoheraRegion;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class LinkRegion
{
    use DispatchesJobs;

    public function __construct(
        public KoheraRegion $koheraRegion
    ) {}

    public function handle(): bool
    {
        if ($this->regionExists($this->koheraRegion) && $this->municipalityExists($this->koheraRegion)) 
        {
            return $this->linkMunicipalitiesToRegion($this->koheraRegion);
        }
        
        return true;
    }

    private function regionExists(KoheraRegion $koheraRegion): bool
    {
        return Region::where('region_id', $koheraRegion->regionId())->exists();
    }

    private function municipalityExists(KoheraRegion $koheraRegion): bool
    {
        return Municipality::where('postal_code', $koheraRegion->postalCode())->exists();
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