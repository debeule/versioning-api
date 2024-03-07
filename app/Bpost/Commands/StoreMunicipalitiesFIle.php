<?php

declare(strict_types=1);

namespace App\Bpost\Commands;

use App\Imports\Values\MunicipalitiesUri;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

final class StoreMunicipalitiesFIle
{
    public function __construct(
        private MunicipalitiesUri $uri = new MunicipalitiesUri(),
    ) {}
    
    public function store(string $file): bool
    {
        $this->clearFilePath();
        return Storage::disk('local')->put($this->uri, $file);
    }

    public function clearFilePath(): void
    {
        if (File::exists($this->uri)) 
        {
            File::delete($this->uri);
        }
    }
}