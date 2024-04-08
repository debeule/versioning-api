<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\ImportFileToStorage;
use App\Testing\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImportFileToStorageTest extends TestCase
{
    /** @test */
    public function itCanImportFileToStorage(): void
    {
        $source = 'http://example.com/source/file.txt';
        $destination = 'destination/file.txt';

        Http::fake([
            $source => Http::response('File content from source', 200),
        ]);

        $importer = new ImportFileToStorage($source, $destination);
        $importer->handle();

        $this->assertTrue(Storage::disk('local')->exists($destination));
        $this->assertEquals('File content from source', Storage::disk('local')->get($destination));

        Storage::disk('local')->delete($destination);
    }
}