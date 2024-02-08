<?php 

namespace App\Schools\Commands;

use App\Schools\Municipality;
use App\Kohera\DwhSchool;


final class CreateNewMunicipalityCommand
{
    public function __invoke(DwhSchool $dwhSchool): bool
    {
        if (!$this->recordExists($dwhSchool)) 
        {
            return $this->buildRecord($dwhSchool);
        }
        
        if ($this->recordExists($dwhSchool)) 
        {
            return $this->updateRecord($dwhSchool);
        }
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

    public function updateRecord(DwhSchool $dwhSchool): bool
    {
        $municipality = Municipality::where('postal_code', $dwhSchool->Postcode)->first();

        $municipality->name = $dwhSchool->Gemeente;

        return $municipality->save();
    }
}