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
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

final class RetrieveFromSourceTest extends TestCase
{
    #[Test]
    public function returnsFileContentsFromSource(): void
    {
        $data = [
            'source' => config('tatooine.test_file_url'),
        ];

        $result = app(Pipeline::class)
            ->send($data)
            ->through([RetrieveFromSource::class])
            ->thenReturn();

        $this->assertEquals(
            Storage::disk('local')->get('excel/TestFile.xls'),
            $result['file']
        );
    }
}