<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use Illuminate\Support\Collection;
use App\Services\Pipes\ArrayToCollection;
use App\Bpost\Municipality;
use Illuminate\Pipeline\Pipeline;

final class SanitizeSpreadsheetArrayTest extends TestCase
{
    #[Test]
    public function returnsCollectionOfobjectType(): void
    {
        $municiaplities = BpostMunicipalityFactory::new()->count(2)->makeArray();
        
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