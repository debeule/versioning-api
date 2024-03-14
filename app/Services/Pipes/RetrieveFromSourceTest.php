<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Testing\TestCase;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;

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