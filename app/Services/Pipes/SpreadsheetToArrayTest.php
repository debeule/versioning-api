<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use Illuminate\Support\Collection;
use App\Services\Pipes\SpreadsheetToArray;
use App\Bpost\Municipality;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\File;


final class SpreadsheetToArrayTest extends TestCase
{
    private string $filePath = 'excel/municipalities.xls';

    #[Test]
    public function returnsCollectionOfobjectType(): void
    {
        $bpostMunicipalities = BpostMunicipalityFactory::new()->count(2)->make();
        
        if (File::exists($this->filePath)) File::delete($this->filePath);

        $bpostMunicipalities->storeExcel($this->filePath);

        $data = [
            'source' => $this->filePath,
        ];

        $result = app(Pipeline::class)
            ->send($data)
            ->through([SpreadsheetToArray::class])
            ->thenReturn();
            
        $this->assertisArray($result['spreadsheetArray']);
        $this->assertEquals(count($result['spreadsheetArray']), 2);
    }

}