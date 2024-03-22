<?php

declare(strict_types=1);

namespace App\Services;

use App\Testing\TestCase;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;

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