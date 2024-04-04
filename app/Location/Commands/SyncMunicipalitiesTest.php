<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Location\Municipality;
use App\Testing\TestCase;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
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
        
        $this->dispatchSync(new SyncMunicipalities);

        $this->assertEquals(Municipality::count(), $bpostMunicipalities->count());
    }

    #[Test]
    public function itSoftDeletesMunicipalityRecordsWhenDeleted(): void
    {
        $bpostMunicipalities = BpostMunicipalityFactory::new()->count(2)->create();
        $bpostMunicipalities->storeExcel($this->filePath);

        $this->dispatchSync(new SyncMunicipalities);
        
        $bpostMunicipalityRecordId = $bpostMunicipalities->first()->recordId();
        Municipality::first()->delete();
        
        $this->dispatchSync(new SyncMunicipalities);

        $this->assertSoftDeleted(Municipality::where('record_id', $bpostMunicipalityRecordId)->first());
        $this->assertGreaterThan($bpostMunicipalities->count(), Municipality::count());
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfChangedAndExists(): void
    {
        $bpostMunicipalities = BpostMunicipalityFactory::new()->count(2)->create();
        $bpostMunicipalities->storeExcel($this->filePath);
        
        $this->dispatchSync(new SyncMunicipalities);

        $oldMunicipality = Municipality::where('name', $bpostMunicipalities->first()->name())->first();

        $newHeadMunicipality = "new head municipality";
        $bpostMunicipalities->first()->Hoofdgemeente = $newHeadMunicipality;

        $bpostMunicipalities->storeExcel($this->filePath);
        
        $this->dispatchSync(new SyncMunicipalities);

        $updatedMunicipality = Municipality::where('head_municipality', $newHeadMunicipality)->first();
        
        $this->assertTrue($oldMunicipality->head_municipality !== $updatedMunicipality->head_municipality);
        $this->assertSoftDeleted($oldMunicipality);

        $this->assertEquals($updatedMunicipality->head_municipality, $newHeadMunicipality);

        
        $this->assertEquals($oldMunicipality->record_id, $updatedMunicipality->record_id);
    }
}