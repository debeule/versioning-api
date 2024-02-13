<?php 

declare(strict_types=1);

namespace App\Schools\Commands;

use App\Schools\Municipality;
use App\Kohera\School as KoheraSchool;


final class CreateMunicipality
{
    public function __invoke(KoheraSchool $koheraSchool): bool
    {
        if (!$this->recordExists($koheraSchool)) 
        {
            return $this->buildRecord($koheraSchool);
        }

        return true;
    }

    private function recordExists(KoheraSchool $koheraSchool): bool
    {
        return Municipality::where('postal_code', $koheraSchool->Postcode)->exists();
    }

    private function buildRecord(KoheraSchool $koheraSchool): bool
    {
        $newMunicipality = new Municipality();

        $newMunicipality->name = $koheraSchool->Gemeente;
        $newMunicipality->postal_code = $koheraSchool->Postcode;

        return $newMunicipality->save();
    }
}