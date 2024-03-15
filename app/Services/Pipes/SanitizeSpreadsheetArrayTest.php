<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Testing\TestCase;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use Illuminate\Pipeline\Pipeline;use PHPUnit\Framework\Attributes\Test;

final class SanitizeSpreadsheetArrayTest extends TestCase
{
    #[Test]
    public function returnsCollectionOfobjectType(): void
    {
        $municiaplities = BpostMunicipalityFactory::new()->count(2)->createArray();
        
        $municiaplities[0]['4'] = 'non existant province';

        $data = [
            'spreadsheetArray' => $municiaplities,
        ];

        $result = app(Pipeline::class)
            ->send($data)
            ->through([SanitizeSpreadsheetArray::class])
            ->thenReturn();
            
        $this->assertisArray($result);
        $this->assertEquals(count($result), 1);
    }

}