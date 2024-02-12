<?php 

declare(strict_types=1);

namespace App\Schools\Commands;

use App\Schools\Municipality;
use App\Kohera\DwhSchool;


final class CreateNewMunicipality
{
    public function __invoke(DwhSchool $dwhSchool): bool
    {
        if (!$this->recordExists($dwhSchool)) 
        {
            return $this->buildRecord($dwhSchool);
        }

        return true;
    }

    private function recordExists(DwhSchool $dwhSchool): bool
    {
        return Municipality::where('postal_code', $dwhSchool->Postcode)->exists();
    }

    private function buildRecord(DwhSchool $dwhSchool): bool
    {
        $newMunicipality = new Municipality();

        $newMunicipality->name = $dwhSchool->Gemeente;
        $newMunicipality->postal_code = $dwhSchool->Postcode;

        return $newMunicipality->save();
    }
}