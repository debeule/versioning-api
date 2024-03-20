<?php

declare(strict_types=1);

namespace App\Services;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Storage;

final class ImportFileToStorageTest extends TestCase
{
    #[Test]
    public function itReturnsString(): void
    {
        $source = config('tatooine.test_file_url');
        $destination = 'excel/TestFile.xls';

        $result = ImportFileToStorage::setup($source, $destination)->pipe();
        
        $this->assertTrue(Storage::exists($destination));
    }

}