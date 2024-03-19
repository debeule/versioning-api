<?php

declare(strict_types=1);

namespace App\Bpost\Commands;

use App\Location\Municipality;
use App\Testing\TestCase;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;

final class SyncMunicipalitiesTest extends TestCase
{
    private string $filePath = 'excel/municipalities.xls';

    #[Before]
    public function ensureNoFilePresent(): void
    {
        if (File::exists($this->filePath)) File::delete($this->filePath);
    }

    #[Test]
    public function itCreatesMunicipalityRecordsWhenNotExists(): void
    {
        $bpostMunicipalities = BpostMunicipalityFactory::new()->count(2)->create();
        
        $bpostMunicipalities->storeExcel($this->filePath);

        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();

        $municipalitiesCount = Municipality::count();
        $bpostMunicipalitiesCount = $bpostMunicipalities->count() - 1;

        if (File::exists($this->filePath)) File::delete($this->filePath);

        $bpostMunicipalities->push(BpostMunicipalityFactory::new()->create());
        $bpostMunicipalities->storeExcel($this->filePath);

        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();

        $modifiedMunicipalitiesCount = Municipality::count();
        $modifiedBpostMunicipalitiesCount = $bpostMunicipalities->count() - 1;

        $this->assertGreaterThan($municipalitiesCount, $modifiedMunicipalitiesCount);
        $this->assertEquals($modifiedBpostMunicipalitiesCount, $modifiedBpostMunicipalitiesCount);
    }

    #[Test]
    public function itSoftDeletesRecordsWhenDeleted(): void
    {
        $bpostMunicipalities = BpostMunicipalityFactory::new()->count(3)->create();
        
        $bpostMunicipalities->storeExcel($this->filePath);

        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();
        
        if (File::exists($this->filePath)) File::delete($this->filePath);

        $deletedMunicipality = $bpostMunicipalities->pop();
        
        $bpostMunicipalities->storeExcel($this->filePath);
        
        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();

        $this->assertSoftDeleted(Municipality::where('record_id', $deletedMunicipality->recordId())->first());
        $this->assertGreaterThan($bpostMunicipalities->count() - 1, Municipality::get()->count());
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfChangedAndExists(): void
    {
        $bpostMunicipalities = BpostMunicipalityFactory::new()->count(2)->create();

        $bpostMunicipalities->storeExcel($this->filePath);

        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();

        $bpostMunicipality = $bpostMunicipalities->pop();
        $originalMunicipalityRecord = Municipality::where('name', $bpostMunicipality->name())->first();
        
        $bpostMunicipality->Plaatsnaam = 'new name';
        $bpostMunicipalities->push($bpostMunicipality);
        $bpostMunicipalities->storeExcel($this->filePath);

        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();

        $updatedMunicipalityRecord = Municipality::where('name', $bpostMunicipality->name())->first();

        $this->assertNotEquals($originalMunicipalityRecord->name, $updatedMunicipalityRecord->name);
        $this->assertSoftDeleted($originalMunicipalityRecord);

        $this->assertEquals($updatedMunicipalityRecord->name, $bpostMunicipality->name());
    }
}