<?php

declare(strict_types=1);

namespace App\Bpost\Commands;

use App\Location\Municipality;
use App\Testing\TestCase;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;use Illuminate\Support\Facades\File;
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
    public function itDispatchesCreateMunicipalitiesWhenNotExists(): void
    {
        $bpostMunicipalities = BpostMunicipalityFactory::new()->count(4)->create();
        
        $bpostMunicipalities->storeExcel($this->filePath);

        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();

        $municipalitiesCount = Municipality::get()->count();
        $bpostMunicipalitiesCount = $bpostMunicipalities->count() - 1;

        if (File::exists($this->filePath)) File::delete($this->filePath);

        $bpostMunicipalities->push(BpostMunicipalityFactory::new()->create());
        $bpostMunicipalities->storeExcel($this->filePath);

        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();

        $modifiedMunicipalitiesCount = Municipality::get()->count();
        $modifiedBpostMunicipalitiesCount = $bpostMunicipalities->count() - 1;

        $this->assertGreaterThan($municipalitiesCount, $modifiedMunicipalitiesCount);
        $this->assertEquals($modifiedBpostMunicipalitiesCount, $modifiedBpostMunicipalitiesCount);
    }

    #[Test]
    public function itSoftDeletesDeletedRecords(): void
    {
        $bpostMunicipalities = BpostMunicipalityFactory::new()->count(4)->create();

        $bpostMunicipalities->storeExcel($this->filePath);

        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();
        
        if (File::exists($this->filePath)) File::delete($this->filePath);

        $deletedMunicipality = $bpostMunicipalities->pop();
        $bpostMunicipalities->storeExcel($this->filePath);
        
        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();
        
        $this->assertSoftDeleted(Municipality::onlyTrashed()->where('postal_code', $deletedMunicipality->postalCode())->first());

        $existingMunicipalities = Municipality::get();
        
        $this->assertGreaterThan($bpostMunicipalities->count() - 1, $existingMunicipalities->count());
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfChangedAndExists(): void
    {
        $bpostMunicipality = BpostMunicipalityFactory::new()->create();

        $this->dispatchSync(new CreateMunicipality($bpostMunicipality));

        $oldMunicipalityRecord = Municipality::where('name', $bpostMunicipality->name())->first();
        
        $bpostMunicipality->Plaatsnaam = 'new name';
        
        $this->dispatchSync(new CreateMunicipality($bpostMunicipality));

        $updatedMunicipalityRecord = Municipality::where('name', $bpostMunicipality->name())->first();

        $this->assertNotEquals($oldMunicipalityRecord->name, $updatedMunicipalityRecord->name);
        $this->assertSoftDeleted($oldMunicipalityRecord);

        $this->assertEquals($updatedMunicipalityRecord->name, $bpostMunicipality->name());
        $this->assertEquals($oldMunicipalityRecord->record_id, $updatedMunicipalityRecord->record_id);
    }
}