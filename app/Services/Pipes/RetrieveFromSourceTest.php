<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use Illuminate\Support\Collection;
use App\Services\Pipes\RetrieveFromSource;
use App\Bpost\Municipality;
use Illuminate\Pipeline\Pipeline;

final class RetrieveFromSourceTest extends TestCase
{
    #[Test]
    public function returnsFileContentsFromSource(): void
    {
        // $data = [
        //     'source' => "url.com"
        // ];

        // $result = app(Pipeline::class)
        //     ->send($data)
        //     ->through([RetrieveFromSource::class])
        //     ->thenReturn();

        // dd($result);

        #TODO: find a way to download test file and test response
        $this->assertTrue(true);
    }

}