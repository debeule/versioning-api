<?php


declare(strict_types=1);

namespace App\Location\Commands;

use App\Extensions\Eloquent\Scopes\FromVersion;
use App\Location\Municipality;
use App\Imports\Queries\Region;
use App\Location\Region as DbRegion;
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
        $municipality = Municipality::where('postal_code', $region->postalCode())
        ->tap($this->fromVersion)
        ->first();
        
        if(empty($municipality)) return false;

        $municipality->region_id = DbRegion::where('record_id', $region->recordId())->first()->id;
        
        return $municipality->save();
    }
}