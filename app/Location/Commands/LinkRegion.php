<?php


declare(strict_types=1);

namespace App\Location\Commands;

use App\Extensions\Eloquent\Scopes\FromVersion;
use App\Kohera\Region as KoheraRegion;
use App\Location\Municipality;
use Illuminate\Foundation\Bus\DispatchesJobs;

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
        # TODO: make into / use scope
        $municipality = Municipality::where('postal_code', $koheraRegion->postalCode())
        ->tap($this->fromVersion)
        ->first();

        if(empty($municipality)) return false;

        $municipality->record_id = $koheraRegion->recordId();

        return $municipality->save();
    }
}