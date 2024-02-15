<?php 

declare(strict_types=1);

namespace App\School\Commands;

use App\School\Municipality;
use App\Bpost\Municipality as BpostMunicipality;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class CreateMunicipality
{
    use DispatchesJobs;

    public function __construct(
        public BpostMunicipality $bpostMunicipality
    ) {}

    public function handle(BpostMunicipality $bpostMunicipality): bool
    {
        if (!$this->recordExists($this->bpostMunicipality)) 
        {
            return $this->buildRecord($this->bpostMunicipality);
        }

        return true;
    }

    private function recordExists(BpostMunicipality $bpostMunicipality): bool
    {
        return Municipality::where('postal_code', $bpostMunicipality->Postalcode())->exists();
    }

    private function buildRecord(BpostMunicipality $bpostMunicipality): bool
    {
        $newMunicipality = new Municipality();

        $newMunicipality->name = $bpostMunicipality->name();
        $newMunicipality->postal_code = $bpostMunicipality->postalCode();
        $newMunicipality->province = $bpostMunicipality->province();
        $newMunicipality->head_municipality = $bpostMunicipality->headMunicipality();
        
        return $newMunicipality->save();
    }
}