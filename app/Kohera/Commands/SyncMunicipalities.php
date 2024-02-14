<?php

declare(strict_types=1);

namespace App\Kohera\commands;

use App\School\Municipality;
use App\Imports\Sanitizer\Sanitizer;
use App\Kohera\Queries\AllMunicipalities as AllKoheraMunicipalities;
use App\School\Commands\CreateMunicipality;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class SyncMunicipalities
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $existingMunicipalities = Municipality::all();
        $processedMunicipalities = [];

        $AllkoheraMunicipalities = new AllKoheraMunicipalities();
        
        foreach ($AllkoheraMunicipalities->get() as $key => $koheraMunicipality) 
        {
            $sanitizer = new Sanitizer();
            $koheraMunicipality = $sanitizer->cleanAllFields($koheraMunicipality);
            
            if (in_array($koheraMunicipality->name, $processedMunicipalities)) 
            {
                continue;
            }

            $this->dispatchSync(new CreateMunicipality($koheraMunicipality));

            $existingMunicipalities = $existingMunicipalities->where('name', "!=", $koheraMunicipality->name);
            
            array_push($processedMunicipalities, $koheraMunicipality->name);
        }

        //Municipality found in sports table but not in koheraMunicipalities
        foreach ($existingMunicipalities as $existingMunicipality) 
        {
            $existingMunicipality->delete();
        }
    }
}