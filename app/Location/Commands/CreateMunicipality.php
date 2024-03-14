<?php


declare(strict_types=1);

namespace App\Location\Commands;

use App\Bpost\Municipality as BpostMunicipality;
use App\Location\Municipality;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class CreateMunicipality
{
    use DispatchesJobs;

    public function __construct(
        public BpostMunicipality $bpostMunicipality
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->bpostMunicipality)->save();
    }
    
    private function buildRecord(BpostMunicipality $bpostMunicipality): Municipality
    {
        $newMunicipality = new Municipality();

        $newMunicipality->name = $bpostMunicipality->name();
        $newMunicipality->postal_code = $bpostMunicipality->postalCode();
        $newMunicipality->province = $bpostMunicipality->province();

        $headMunicipality = $bpostMunicipality->headMunicipality() !== null ? strtolower($bpostMunicipality->headMunicipality()) : null;
        $newMunicipality->head_municipality = $headMunicipality;
        $newMunicipality->record_id = $bpostMunicipality->recordId();
        
        return $newMunicipality;
    }
}