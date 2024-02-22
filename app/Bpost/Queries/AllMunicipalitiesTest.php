<?php

declare(strict_types=1);

namespace App\Bpost\Queries;

use App\Testing\TestCase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Bpost\Municipality;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use Illuminate\Support\Facades\File;

final class AllMunicipalitiesTest extends TestCase
{
    private Collection $bpostMunicipalities;
    private string $fileName;
    private string $filePath;
    private AllMunicipalities $allMunicipalities;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->fileName = 'municipalities.xlsx';
        $this->filePath = storage_path('app/' . $this->fileName);

        $this->bpostMunicipalities = BpostMunicipalityFactory::new()->count(4)->make();

        if (File::exists($this->filePath)) 
        {
            File::delete($this->filePath);
        }

        $this->bpostMunicipalities->storeExcel($this->fileName);

        $this->allMunicipalities = new AllMunicipalities;
    }

    /**
     * @test
     */
    public function queryReturnsArrayOfMunicipalities(): void
    {
        $this->assertIsArray($this->allMunicipalities->query());
    }

    /**
     * @test
     */
    public function getReturnsCollectionOfMunicipalities(): void
    {
        $this->assertInstanceOf(Collection::class, $this->allMunicipalities->get());
        $this->assertInstanceOf(Municipality::class, $this->allMunicipalities->get()[0]);
    }
    /**
     * @test
     */
    public function ItCanDOwnloadMunicipalitiesExcelFile(): void
    {
        putenv('IMPORT_MUNICIPALITIES = true');

        if (File::exists($this->filePath)) 
        {
            File::delete($this->filePath);
        }

        $this->allMunicipalities->importMunicipalitiesFile();
        
        $this->assertFileExists($this->filePath);

        putenv('IMPORT_MUNICIPALITIES = false');
    }
}