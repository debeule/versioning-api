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

        if ($this->recordExists($this->bpostMunicipality) && $this->recordHasChanged($this->bpostMunicipality)) 
        {
            return $this->createNewRecordVersion($this->bpostMunicipality);
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

        $newMunicipality->name = strtolower($bpostMunicipality->name());
        $newMunicipality->postal_code = $bpostMunicipality->postalCode();
        $newMunicipality->province = $bpostMunicipality->province();

        $headMunicipality = $bpostMunicipality->headMunicipality() !== null ? strtolower($bpostMunicipality->headMunicipality()) : null;
        $newMunicipality->head_municipality = $headMunicipality;
        
        return $newMunicipality->save();
    }

    private function recordHasChanged(BpostMunicipality $bpostMunicipality): bool
    {
        $municipality = Municipality::where('postal_code', $bpostMunicipality->postalCode())->first();

        $recordhasChanged = false;

        $recordhasChanged = $recordhasChanged || $municipality->name !== strtolower($bpostMunicipality->name());
        $recordhasChanged = $recordhasChanged || $municipality->province !== $bpostMunicipality->province();

        if (!is_null($bpostMunicipality->headMunicipality())) 
        {
            $recordhasChanged = $municipality->head_municipality !== strtolower($bpostMunicipality->headMunicipality());
        }

        return $recordhasChanged;
    }

    public function createNewRecordVersion(BpostMunicipality $bpostMunicipality): bool
    {
        $municipality = Municipality::where('postal_code', $bpostMunicipality->postalCode())->delete();

        return $this->buildRecord($bpostMunicipality);
    }
}