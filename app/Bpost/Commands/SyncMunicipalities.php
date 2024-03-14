<?php

declare(strict_types=1);

namespace App\Bpost\Commands;

use App\Bpost\Queries\AllMunicipalities as allBpostMunicipalities;
use App\Location\Commands\CreateMunicipality;
use App\Location\Commands\SoftDeleteMunicipality;
use App\Location\Municipality;
use App\Services\ProcessImportedRecords;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncMunicipalities
{
    use DispatchesJobs;

    public function __construct(
        private AllBpostMunicipalities $allBpostMunicipalities = new AllBpostMunicipalities(),
    ) {}
        

    public function __invoke(): void
    {
        $allMunicipalities = Municipality::get();

        $result = ProcessImportedRecords::setup($this->allBpostMunicipalities->get(), $allMunicipalities)->pipe();
        
        foreach ($result['update'] as $Municipality) 
        {
            $this->dispatchSync(new SoftDeleteMunicipality(Municipality::where('record_id', $koheraMunicipality->recordId())->first()));
            $this->dispatchSync(new CreateMunicipality($Municipality));
        }

        foreach ($result['create'] as $koheraMunicipality) 
        {
            $this->dispatchSync(new CreateMunicipality($koheraMunicipality));
        }

        foreach ($result['delete'] as $koheraMunicipality) 
        {
            $this->dispatchSync(new SoftDeleteMunicipality($koheraMunicipality));
        }
    }
}