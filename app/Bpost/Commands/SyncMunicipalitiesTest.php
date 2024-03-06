<?php

declare(strict_types=1);

namespace App\Bpost\Commands;

use App\Location\Municipality;
use App\Testing\TestCase;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;

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

        $this->assertGreaterThan($existingMunicipalities->count(), $bpostMunicipalities->count() - 1);

        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();

        $existingMunicipalities = Municipality::get();
        
        $this->assertEquals($existingMunicipalities->count(), $bpostMunicipalities->count() - 1);
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
        
        $this->assertGreaterThan($bpostMunicipalities->count() - 1, $existingMunicipalities->count());
    }
}