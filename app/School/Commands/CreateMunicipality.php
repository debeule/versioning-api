<?php 

declare(strict_types=1);

namespace App\School\Commands;

use App\School\Municipality;
use App\Kohera\School as KoheraSchool;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class CreateMunicipality
{
    use DispatchesJobs;

    public function __construct(
        public KoheraSchool $koheraSchool
    ) {}

    public function handle(KoheraSchool $koheraSchool): bool
    {
        if (!$this->recordExists($this->koheraSchool)) 
        {
            return $this->buildRecord($this->koheraSchool);
        }

        return true;
    }

    private function recordExists(KoheraSchool $koheraSchool): bool
    {
        return Municipality::where('postal_code', $koheraSchool->Postcode)->exists();
    }

    private function buildRecord(KoheraSchool $koheraSchool): bool
    {
        $newMunicipality = new Municipality();

        $newMunicipality->name = $koheraSchool->Gemeente;
        $newMunicipality->postal_code = $koheraSchool->Postcode;

        return $newMunicipality->save();
    }
}