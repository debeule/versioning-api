<?php

declare(strict_types=1);

namespace App\Bpost\Commands;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\School\School;
use App\Bpost\School as BpostSchool;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use Database\Main\Factories\AddressFactory;
use App\Bpost\Commands\SyncSchools;
use App\Bpost\Address as BpostAddress;
use App\Bpost\Municipality as BpostMunicipality;
use App\Bpost\Queries\AllMunicipalities;
use App\Location\Municipality;
use App\Location\Address;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

final class SyncMunicipalitiesTest extends TestCase
{
    private string $filePath = 'municipalities.xls';

    #[Before]
    public function ensureNoFilePresent(): void
    {
        if (File::exists($this->filePath)) 
        {
            File::delete($this->filePath);
        }
    }

    #[Test]
    public function itDispatchesCreateMunicipalitiesWhenNotExists(): void
    {
        $bpostMunicipalities = BpostMunicipalityFactory::new()->count(4)->make();

        $bpostMunicipalities->storeExcel($this->filePath);

        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();

        $bpostMunicipalities->push(BpostMunicipalityFactory::new()->make());

        if (File::exists($this->filePath)) 
        {
            File::delete($this->filePath);
        }

        $bpostMunicipalities->storeExcel($this->filePath);

        $existingMunicipalities = Municipality::get();

        $this->assertGreaterThan($existingMunicipalities->count(), $bpostMunicipalities->count() -1);

        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();

        $existingMunicipalities = Municipality::get();
        
        $this->assertEquals($existingMunicipalities->count(), $bpostMunicipalities->count() -1);
    }

    #[Test]
    public function itSoftDeletesDeletedRecords(): void
    {
        $bpostMunicipalities = BpostMunicipalityFactory::new()->count(4)->make();

        $bpostMunicipalities->storeExcel($this->filePath);

        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();

        $deletedMunicipality = $bpostMunicipalities->pop();

        if (File::exists($this->filePath)) 
        {
            File::delete($this->filePath);
        }

        $bpostMunicipalities->storeExcel($this->filePath);
        
        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();
        
        $this->assertSoftDeleted(Municipality::where('postal_code', $deletedMunicipality->postalCode())->first());

        $existingMunicipalities = Municipality::get();
        
        $this->assertGreaterThan($bpostMunicipalities->count() -1, $existingMunicipalities->count());
    }
}