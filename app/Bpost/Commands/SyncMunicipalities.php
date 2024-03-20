<?php

declare(strict_types=1);

namespace App\Bpost\Commands;

use App\Bpost\Queries\AllMunicipalities as AllBpostMunicipalities;
use App\Location\Commands\CreateMunicipality;
use App\Location\Commands\SoftDeleteMunicipality;
use App\Location\Municipality;
use App\Location\Queries\AllMunicipalities;
use App\Services\ProcessImportedRecords;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncMunicipalities
{
    use DispatchesJobs;

    public function __construct(
        private AllBpostMunicipalities $allBpostMunicipalities = new AllBpostMunicipalities(),
        private AllMunicipalities $allMunicipalities = new AllMunicipalities(),
    ) {}
        

    public function __invoke(): void
    {
        $result = ProcessImportedRecords::setup($this->allBpostMunicipalities->get(), $this->allMunicipalities->get())->pipe();
        
        foreach ($result['update'] as $koheraMunicipality) 
        {
            $this->dispatchSync(new SoftDeleteMunicipality(Municipality::where('record_id', $koheraMunicipality->recordId())->first()));
            $this->dispatchSync(new CreateMunicipality($koheraMunicipality));
        }

        foreach ($result['create'] as $koheraMunicipality) 
        {
            $this->dispatchSync(new CreateMunicipality($koheraMunicipality));
        }

        foreach ($result['delete'] as $municipality) 
        {
            $this->dispatchSync(new SoftDeleteMunicipality($municipality));
        }
    }
}