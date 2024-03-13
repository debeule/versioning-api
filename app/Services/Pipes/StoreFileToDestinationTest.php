<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use Illuminate\Support\Collection;
use App\Services\Pipes\StoreFileToDestination;
use App\Bpost\Municipality;
use Illuminate\Pipeline\Pipeline;
use Maatwebsite\Excel\Facades\Excel;
use Database\Bpost\Factories\MunicipalityFactory;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

final class StoreFileToDestinationTest extends TestCase
{
    #[Test] 
    public function returnsCollectionOfobjectType(): void
    {
        $file = UploadedFile::fake()->create('image.jpg');

        $data = [
            'destination' => '',
            'file' => $file,
        ];

        $result = app(Pipeline::class)
            ->send($data)
            ->through([StoreFileToDestination::class])
            ->thenReturn();

        $fileExists = File::exists(storage_path('app/' . $file->hashName()));

        if (File::exists(storage_path('app/' . $file->hashName()))) File::delete(storage_path('app/' . $file->hashName()));

        $this->assertTrue($fileExists);
    }
}