<?php

namespace App\Bpost\Commands;

use App\Bpost\Bpost;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use App\Imports\Values\MunicipalitiesUri;

final class DownloadMunicipalities
{
    private string $file;

    public function __construct(
        private MunicipalitiesUri $uri = new MunicipalitiesUri(),
    ) {
        $this->file = Http::withOptions(['verify' => false])->get((string) $this->uri)->body();
    }
    
    public function get()
    {
        return $this->file;
    }
}