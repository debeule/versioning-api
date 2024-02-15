<?php

declare(strict_types=1);

namespace App\Kohera\commands;

use App\School\Municipality;
use App\Imports\Sanitizer\Sanitizer;
use App\bpost\Queries\AllMunicipalities as bpostMunicipalities;
use App\School\Commands\CreateMunicipality;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class SyncMunicipalities
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $existingMunicipalities = Municipality::all();
        $processedMunicipalities = [];

        $bpostMunicipalities = new BpostMunicipalities();
        
        foreach ($bpostMunicipalities->get() as $bpostMunicipality) 
        {
            if (in_array($bpostMunicipality->name(), $processedMunicipalities)) 
            {
                continue;
            }

            $this->dispatchSync(new CreateMunicipality($bpostMunicipality));

            $existingMunicipalities = $existingMunicipalities->where('name', "!=", $bpostMunicipality->name());

            array_push($processedMunicipalities, $bpostMunicipality->name());
        }

        //Municipality found in sports table but not in koheraMunicipalities
        foreach ($existingMunicipalities as $existingMunicipality) 
        {
            $existingMunicipality->delete();
        }
    }
}