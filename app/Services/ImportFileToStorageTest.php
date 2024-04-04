<?php

declare(strict_types=1);

namespace App\Services;

use PhpUnit\Framework\TestCase;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;

final class ImportFileToStorageTest extends TestCase
{
    #[Test]
    public function itReturnsString(): void
    {
        # TODO: fake
        $source = 'https://freetestdata.com/wp-content/uploads/2021/09/Free_Test_Data_100KB_XLS.xls';
        $destination = 'excel/TestFile.xls';

        $result = ImportFileToStorage::setup($source, $destination)->pipe();
        
        $this->assertTrue(Storage::exists($destination));
    }

}