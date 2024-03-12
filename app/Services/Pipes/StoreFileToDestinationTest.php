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

final class StoreFileToDestinationTest extends TestCase
{
    #[Test]
    public function returnsCollectionOfobjectType(): void
    {
        
        if (File::exists($this->filePath)) File::delete($this->filePath);

        $data = [
            'destination' => 'excel/municipalities.xls',
        ];
    }

}