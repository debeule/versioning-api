<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Testing\TestCase;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;


final class SpreadsheetToArrayTest extends TestCase
{
    private string $filePath = 'excel/municipalities.xls';

    #[Test]
    public function returnsCollectionOfobjectType(): void
    {
        $bpostMunicipalities = BpostMunicipalityFactory::new()->count(2)->create();
        
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