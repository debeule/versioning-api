<?php

declare(strict_types=1);

namespace App\Bpost\Services;

use App\Imports\Values\MunicipalitiesUri;
use Illuminate\Support\Facades\File;

final class StoreMunicipalitiesFIle
{
    public function __construct(
        private MunicipalitiesUri $uri = new MunicipalitiesUri(),
    ) {}
    
    public function store(): void
    {
        $this->clearFilePath();
        $this->status = Storage::disk('local')->put($this->uri, $file);
    }

    public function clearFilePath(): void
    {
        if (File::exists($this->uri)) 
        {
            File::delete($this->uri);
        }
    }
}