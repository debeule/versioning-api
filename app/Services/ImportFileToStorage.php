<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

final class ImportFileToStorage
{
    public function __construct(
        private string $source,
        private string $destination,
    ) {}

    public function handle(): void
    {
        if (File::exists($this->destination)) File::delete($this->destination);

        $file = Http::withOptions(['verify' => false])->get((string) $this->source)->body();
        Storage::disk('local')->put($this->destination, $file);
    }
}