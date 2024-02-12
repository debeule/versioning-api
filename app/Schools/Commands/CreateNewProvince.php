<?php 

declare(strict_types=1);

namespace App\Schools\Commands;

use App\Schools\Province;
use App\Kohera\DwhRegion;


final class CreateNewProvince
{
    public function __invoke(DwhRegion $dwhRegion): bool
    {
        if (!$this->recordExists($dwhRegion)) 
        {
            return $this->buildRecord($dwhRegion);
        }

        return true;
    }

    private function recordExists(DwhRegion $dwhRegion): bool
    {
        return Province::where('name', $dwhRegion->Provincie)->exists();
    }

    public function buildRecord(DwhRegion $dwhRegion): bool
    {
        {
            $newProvince = new Province();
    
            $newProvince->name = $dwhRegion->Provincie;
    
            return $newProvince->save();
        }
    }
}