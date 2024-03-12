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
        if (! $this->recordExists($this->bpostMunicipality)) 
        {
            return $this->buildRecord($this->bpostMunicipality);
        }

        if ($this->recordHasChanged($this->bpostMunicipality)) 
        {
            return $this->createNewRecordVersion($this->bpostMunicipality);
        }

        return false;
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

        $headMunicipality = $bpostMunicipality->headMunicipality() !== null ? strtolower($bpostMunicipality->headMunicipality()) : null;
        $newMunicipality->head_municipality = $headMunicipality;
        
        return $newMunicipality->save();
    }

    private function recordHasChanged(BpostMunicipality $bpostMunicipality): bool
    {
        $municipality = Municipality::where('postal_code', $bpostMunicipality->postalCode())->first();

        $recordhasChanged = false;
        
        $recordhasChanged = $municipality->name !== strtolower($bpostMunicipality->name());
        $recordhasChanged = $recordhasChanged || $municipality->province !== strtolower($bpostMunicipality->province());

        if (! is_null($bpostMunicipality->headMunicipality())) 
        {
            $recordhasChanged = $recordhasChanged || $municipality->head_municipality !== strtolower($bpostMunicipality->headMunicipality());
        }

        return $recordhasChanged;
    }

    public function createNewRecordVersion(BpostMunicipality $bpostMunicipality): bool
    {
        $municipality = Municipality::where('postal_code', $bpostMunicipality->postalCode())->delete();

        return $this->buildRecord($bpostMunicipality);
    }
}