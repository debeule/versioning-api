<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Bpost\Municipality;
use App\Testing\TestCase;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;

final class ArrayToCollectionTest extends TestCase
{
    #[Test]
    public function returnsCollectionOfobjectType(): void
    {
        $municiaplity = BpostMunicipalityFactory::new()->createArray();

        $data = [
            'spreadsheetArray' => $municiaplity,
            'objectType' => Municipality::class,
        ];

        $result = app(Pipeline::class)
            ->send($data)
            ->through([ArrayToCollection::class])
            ->thenReturn();
            
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertInstanceOf(Municipality::class, $result->first());
    }

}