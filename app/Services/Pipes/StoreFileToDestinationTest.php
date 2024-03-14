<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Testing\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;

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