<?php

declare(strict_types=1);

namespace App\Bpost\Commands;

use App\Bpost\Queries\AllMunicipalities as allBpostMunicipalities;
use App\Location\Commands\CreateMunicipality;
use App\Location\Municipality;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class SyncMunicipalities
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $existingMunicipalities = Municipality::get();
        $processedMunicipalities = [];
        
        $bpostMunicipalities = new allBpostMunicipalities();
        
        foreach ($bpostMunicipalities->get() as $bpostMunicipality) 
        {
            if (in_array($bpostMunicipality->postalCode(), $processedMunicipalities)) 
            {
                continue;
            }

            $this->dispatchSync(new CreateMunicipality($bpostMunicipality));

            $existingMunicipalities = $existingMunicipalities->where('postal_code', "!=", $bpostMunicipality->postalCode());

            array_push($processedMunicipalities, $bpostMunicipality->postalCode());
        }

        //Municipality found in sports table but not in koheraMunicipalities
        foreach ($existingMunicipalities as $existingMunicipality) 
        {
            $existingMunicipality->delete();
        }
    }
}