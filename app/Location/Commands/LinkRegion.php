<?php


declare(strict_types=1);

namespace App\Location\Commands;

use App\Extensions\Eloquent\Scopes\FromVersion;
use App\Kohera\Region as KoheraRegion;
use App\Location\Municipality;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Location\Region;

final class LinkRegion
{
    use DispatchesJobs;

    public function __construct(
            public KoheraRegion $koheraRegion,
        private FromVersion $fromVersion = new FromVersion,
    ) {}

    public function handle(): bool
    {
        return $this->linkRegion($this->koheraRegion);
    }

    public function linkRegion(KoheraRegion $koheraRegion): bool
    {
        $municipality = Municipality::where('postal_code', $koheraRegion->postalCode())
        ->tap($this->fromVersion)
        ->first();
        
        if(empty($municipality)) return false;

        $municipality->region_id = Region::where('region_number', $koheraRegion->regionNumber())->first()->id;    
        return $municipality->save();
    }
}