<?php

declare(strict_types=1);

namespace App\Bpost\Commands;

use App\Testing\TestCase;
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
    private Collection $bpostMunicipalities;
    private string $fileName;
    private string $filePath;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->fileName = 'municipalities.xlsx';
        $this->filePath = storage_path('app/'. $this->fileName);

        $this->bpostMunicipalities = BpostMunicipalityFactory::new()->count(4)->make();

        if (File::exists($this->filePath)) 
        {
            File::delete($this->filePath);
        }

        $this->bpostMunicipalities->storeExcel($this->fileName);

        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();
    }

    /**
     * @test
     */
    public function itDispatchesCreateMunicipalitiesWhenNotExists(): void
    {
        $this->bpostMunicipalities->push(BpostMunicipalityFactory::new()->make());

        if (File::exists($this->filePath)) 
        {
            File::delete($this->filePath);
        }

        $this->bpostMunicipalities->storeExcel($this->fileName);

        $existingMunicipalities = Municipality::get();

        $this->assertGreaterThan($existingMunicipalities->count(), $this->bpostMunicipalities->count() -1);

        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();

        $existingMunicipalities = Municipality::get();
        
        $this->assertEquals($existingMunicipalities->count(), $this->bpostMunicipalities->count() -1);
    }

    /**
     * @test
     */
    public function itSoftDeletesDeletedRecords(): void
    {
        $deletedMunicipality = $this->bpostMunicipalities->pop();

        if (File::exists($this->filePath)) 
        {
            File::delete($this->filePath);
        }

        $this->bpostMunicipalities->storeExcel($this->fileName);
        
        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();
        
        $this->assertSoftDeleted(Municipality::withTrashed()->where('postal_code', $deletedMunicipality->postalCode())->first());

        $existingMunicipalities = Municipality::withTrashed()->get();
        
        $this->assertGreaterThan($this->bpostMunicipalities->count() -1, $existingMunicipalities->count());
    }
}