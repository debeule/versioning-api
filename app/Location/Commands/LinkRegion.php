<?php


declare(strict_types=1);

namespace App\Location\Commands;

use App\Extensions\Eloquent\Scopes\FromVersion;
use App\Location\Municipality;
use App\Location\Region;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class LinkRegion
{
    use DispatchesJobs;

    public function __construct(
        public Region $region,
        private FromVersion $fromVersion = new FromVersion,
    ) {}

    public function handle(): bool
    {
        return $this->linkRegion($this->region);
    }

    public function linkRegion(Region $region): bool
    {
        $municipality = Municipality::where('postal_code', $region->postal_code)
        ->tap($this->fromVersion)
        ->first();
        
        if(empty($municipality)) return false;

        $municipality->region_id = Region::where('region_number', $region->region_number)->first()->id;
    
        return $municipality->save();
    }
}