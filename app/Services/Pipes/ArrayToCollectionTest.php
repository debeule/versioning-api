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

final class ArrayToCollectionTest extends TestCase
{
    #[Test]
    public function returnsCollectionOfobjectType(): void
    {
        $municiaplity = BpostMunicipalityFactory::new()->makeArray();

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