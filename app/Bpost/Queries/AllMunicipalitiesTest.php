<?php

declare(strict_types=1);

namespace App\Bpost\Queries;

use App\Bpost\Municipality;
use App\Testing\TestCase;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;

final class AllMunicipalitiesTest extends TestCase
{
    private string $filePath = 'excel/municipalities.xls';

    #[Before]
    public function ensureNoFilePresent(): void
    {
        if (File::exists($this->filePath)) 
        {
            File::delete($this->filePath);
        }
    }

    #[Test]
    public function getReturnsCollectionOfMunicipalities(): void
    {
        $bpostMunicipalities = BpostMunicipalityFactory::new()->count(4);
        $bpostMunicipalities->storeExcel($this->filePath);

        $allMunicipalities = new AllMunicipalities;

        $this->assertInstanceOf(Collection::class, $allMunicipalities->get());
        $this->assertInstanceOf(Municipality::class, $allMunicipalities->get()->first());
    }
}