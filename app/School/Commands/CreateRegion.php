<?php 

declare(strict_types=1);

namespace App\School\Commands;

use App\School\Region;
use App\Kohera\Region as KoheraRegion;
use Illuminate\Foundation\Bus\DispatchesJobs;

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

        return true;
    }

    private function recordExists(KoheraRegion $koheraRegion): bool
    {
        return Region::where('region_id', $koheraRegion->RegioDetailId)->exists();
    }

    public function buildRecord(KoheraRegion $koheraRegion): bool
    {
        $newRegion = new Region();
        $newRegion->name = $koheraRegion->RegionNaam;
        $newRegion->province = $koheraRegion->Provincie;
        $newRegion->region_id = $koheraRegion->RegioDetailId;
        
        return $newRegion->save();
    }
}