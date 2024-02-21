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

final class SyncMunicipalitiesTest extends TestCase
{
    private BpostMunicipality $bpostMunicipalities;
    private string $fileName;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->bpostMunicipalities = BpostMunicipalityFactory::new()->count(3)->make();

        $this->bpostMunicipalities->storeExcel('municipalities.xlsx');

        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();
    }

    /**
     * @test
     */
    public function itDispatchesCreateMunicipalitiesWhenNotExists(): void
    {
        $this->bpostMunicipalities->push(BpostMunicipalityFactory::new()->make());

        $existingMunicipalities = Municipality::get();

        $this->assertGreaterThan($existingMunicipalities->count(), $this->bpostMunicipalities->count());
        dd("hier");
        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();

        $existingMunicipalities = Municipality::get();
        $bpostMunicipalities = BpostMunicipality::get();
        $this->assertEquals($existingMunicipalities->count(), $bpostMunicipalities->count());
    }

    // /**
    //  * @test
    //  */
    // public function itSoftDeletesDeletedRecords(): void
    // {
    //     $bpostMunicipality = BpostMunicipality::first();
    //     $bpostMunicipalityName = $bpostMunicipality->name();
    //     $bpostMunicipality->delete();

        
    //     $syncMunicipalities = new SyncMunicipalities();
    //     $syncMunicipalities();
            
    //     $this->assertSoftDeleted(Municipality::withTrashed()->where('name', $bpostMunicipalityName)->first());

    //     $existingMunicipalities = Municipality::withTrashed()->get();
    //     $bpostMunicipalities = BpostMunicipality::get();

    //     $this->assertGreaterThan($bpostMunicipalities->count(), $existingMunicipalities->count());
    // }
}