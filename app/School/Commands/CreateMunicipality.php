<?php 

declare(strict_types=1);

namespace App\School\Commands;

use App\School\Municipality;
use App\Kohera\Municipality as KoheraMunicipality;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class CreateMunicipality
{
    use DispatchesJobs;

    public function __construct(
        public KoheraMunicipality $koheraMunicipality
    ) {}

    public function handle(KoheraMunicipality $koheraMunicipality): bool
    {
        if (!$this->recordExists($this->koheraMunicipality)) 
        {
            return $this->buildRecord($this->koheraMunicipality);
        }

        return true;
    }

    private function recordExists(KoheraMunicipality $koheraMunicipality): bool
    {
        // return Municipality::where('name', $koheraMunicipality->Postalcode())->exists();
        return false;
    }

    private function buildRecord(KoheraMunicipality $koheraMunicipality): bool
    {        
        $newMunicipality = new Municipality();

        $newMunicipality->name = $koheraMunicipality->name();
        $newMunicipality->postal_code = $koheraMunicipality->postalCode();
        
        return $newMunicipality->save();
    }
}