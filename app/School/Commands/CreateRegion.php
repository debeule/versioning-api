<?php 

declare(strict_types=1);

namespace App\School\Commands;

use App\School\Region;
use App\Kohera\Region as KoheraRegion;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\School\Municipality;

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
        return Region::where('region_id', $koheraRegion->regionId())->exists();
    }

    public function buildRecord(KoheraRegion $koheraRegion): bool
    {
        $newRegion = new Region();

        $newRegion->name = $koheraRegion->name();
        $newRegion->region_id = $koheraRegion->regionId();
        
        $newRegion->save();

        //link municipalities to region
        $municipalities = Municipality::where('postal_code', $koheraRegion->postalCode())->get();

        foreach ($municipalities as $municipality) 
        {
            $municipality->region_id = $newRegion->regionId();
            $municipality->save();
        }
        
        return true;
    }

    public function regionHasChanged(KoheraRegion $koheraRegion): bool
    {
        $region = Region::where('region_id', $koheraRegion->regionId())->first();

        $recordhasChanged = false;

        $recordhasChanged = $region->name !== $koheraRegion->name();
        $recordhasChanged = $region->email !== $koheraRegion->email();
        $recordhasChanged = $region->contact_email !== $koheraRegion->contactEmail();
        $recordhasChanged = $region->type !== $koheraRegion->type();
        $recordhasChanged = $region->student_count !== $koheraRegion->studentCount();
        $recordhasChanged = $region->institution_id !== $koheraRegion->institutionId();

        return $recordhasChanged;
    }
}