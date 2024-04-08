<?php

namespace Tests\Unit\Services;

use App\Services\ImportFileToStorage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Testing\TestCase;

class ImportFileToStorageTest extends TestCase
{
    /** @test */
    public function itCanImportFileToStorage()
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