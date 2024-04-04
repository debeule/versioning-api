<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Imports\Queries\ExternalMunicipalities;
use App\Bpost\Queries\AllMunicipalities;
use App\Location\Commands\CreateMunicipality;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use App\Bpost\Municipality as BpostMunicipality;
use App\Location\Municipality;

final class MunicipalityDiffTest extends TestCase
{
    private string $filePath = 'excel/municipalities.xls';

    #[Test]
    public function itReturnsCorrectAdditions(): void
    {
        $bpostMunicipalities = BpostMunicipalityFactory::new()->count(3)->create();
        $bpostMunicipalities->storeExcel($this->filePath);

        $this->dispatchSync(new CreateMunicipality($bpostMunicipalities->first()));

        $municipalityDiff = app(MunicipalityDiff::class);

        $result = $municipalityDiff->additions();

        $this->assertInstanceOf(BpostMunicipality::class, $result->first());
        $this->assertEquals(2, $result->count());
    }
    
    #[Test]
    public function itReturnsCorrectDeletions(): void
    {
        $bpostMunicipalities = BpostMunicipalityFactory::new()->count(3)->create();
        $bpostMunicipalities->storeExcel($this->filePath);

        $removedBpostMunicipality = $bpostMunicipalities->shift();

        $this->dispatchSync(new CreateMunicipality($removedBpostMunicipality));

        $bpostMunicipalities->storeExcel($this->filePath);

        $municipalityDiff = app(MunicipalityDiff::class);

        $result = $municipalityDiff->deletions();

        $this->assertInstanceOf(Municipality::class, $result->first());
        $this->assertEquals(1, $result->count());
        $this->assertTrue($result->where('head_municipality', $removedBpostMunicipality->headMunicipality())->isNotEmpty());
    }
    
    #[Test]
    public function itReturnsCorrectUpdates(): void
    {
        $bpostMunicipalities = BpostMunicipalityFactory::new()->count(3)->create();
        $bpostMunicipalities->storeExcel($this->filePath);

        $this->dispatchSync(new CreateMunicipality($bpostMunicipalities->first()));

        $newHeadMunicipality = "new head municipality";
        $bpostMunicipalities->first()->Hoofdgemeente = $newHeadMunicipality;

        $bpostMunicipalities->storeExcel($this->filePath);

        $municipalityDiff = app(MunicipalityDiff::class);

        $result = $municipalityDiff->updates();

        $this->assertInstanceOf(BpostMunicipality::class, $result->first());
        $this->assertEquals(1, $result->count());
        $this->assertEquals($newHeadMunicipality, $result->first()->Hoofdgemeente);
    }
}