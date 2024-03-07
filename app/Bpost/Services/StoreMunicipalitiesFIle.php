<?php

namespace App\Bpost\Commands;

use App\Bpost\Bpost;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use App\Imports\Values\BpostUri;

final class StoreMunicipalitiesFIle
{
    public function __construct(
        private BpostUri $uri = new BpostUri(),
    ) {}
    
    public function store()
    {
        $this->clearFilePath();
        $this->status = Storage::disk('local')->put($this->uri, $file);
    }

    public function clearFilePath()
    {
        if (File::exists($this->uri)) 
        {
            File::delete($this->uri);
        }
    }
}