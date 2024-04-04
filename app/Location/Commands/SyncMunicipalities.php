<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Location\Municipality;
use App\Location\Queries\MunicipalityDiff;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncMunicipalities
{
    use DispatchesJobs;

    public function __invoke(MunicipalityDiff $municipalityDiff): void
    {
        foreach ($municipalityDiff->additions() as $externalMunicipality) 
        {
            $this->dispatchSync(new CreateMunicipality($externalMunicipality));
        }

        foreach ($municipalityDiff->deletions() as $municipality) 
        {
            $this->dispatchSync(new SoftDeleteMunicipality($municipality));
        }

        foreach ($municipalityDiff->updates() as $externalMunicipality) 
        {
            $this->dispatchSync(new SoftDeleteMunicipality(Municipality::where('record_id', $externalMunicipality->recordId())->first()));
            $this->dispatchSync(new CreateMunicipality($externalMunicipality));
        }
    }
}