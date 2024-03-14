<?php


declare(strict_types=1);

namespace App\Location\Commands;

use App\Kohera\Region as KoheraRegion;
use App\Location\Municipality;
use App\Location\Region;
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
        
        return false;
    }

    private function regionExists(KoheraRegion $koheraRegion): bool
    {
        return Region::where('record_id', $koheraRegion->recordId())->exists();
    }

    private function municipalityExists(KoheraRegion $koheraRegion): bool
    {
        return Municipality::where('postal_code', $koheraRegion->postalCode())->exists();
    }

    public function linkMunicipalitiesToRegion(KoheraRegion $koheraRegion): bool
    {
        $municipalities = Municipality::where('postal_code', $koheraRegion->postalCode())->get();
        $region = Region::where('record_id', $koheraRegion->recordId())->first();
    
        foreach ($municipalities as $municipality) 
        {
            $municipality->record_id = $region->id;
            $municipality->save();
        }
        
        return true;
    }
}