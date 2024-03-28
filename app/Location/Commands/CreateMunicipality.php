<?php


declare(strict_types=1);

namespace App\Location\Commands;

use App\Imports\Queries\Municipality;
use App\Location\Municipality as DbMunicipality;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class CreateMunicipality
{
    use DispatchesJobs;

    public function __construct(
        public Municipality $municipality
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->municipality)->save();
    }
    
    private function buildRecord(Municipality $municipality): DbMunicipality
    {
        $newMunicipality = new DbMunicipality();

        $newMunicipality->name = $municipality->name();
        $newMunicipality->postal_code = $municipality->postalCode();
        $newMunicipality->province = $municipality->province();

        $headMunicipality = $municipality->headMunicipality() !== null ? strtolower($municipality->headMunicipality()) : null;
        $newMunicipality->head_municipality = $headMunicipality;
        $newMunicipality->record_id = $municipality->recordId();
        
        return $newMunicipality;
    }
}