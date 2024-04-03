<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Location\Queries\MunicipalityDiff;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Location\Municipality;

final class SyncMunicipalities
{
    use DispatchesJobs;

    public function __invoke(MunicipalityDiff $municipalityDiff): void
    {
        foreach ($municipalityDiff->additions() as $koheraMunicipality) 
        {
            $this->dispatchSync(new CreateMunicipality($koheraMunicipality));
        }

        foreach ($municipalityDiff->deletions() as $municipality) 
        {
            $this->dispatchSync(new SoftDeleteMunicipality($municipality));
        }

        foreach ($municipalityDiff->updates() as $koheraMunicipality) 
        {
            $this->dispatchSync(new SoftDeleteMunicipality(Municipality::where('record_id', $koheraMunicipality->recordId())->first()));
            $this->dispatchSync(new CreateMunicipality($koheraMunicipality));
        }
    }
}