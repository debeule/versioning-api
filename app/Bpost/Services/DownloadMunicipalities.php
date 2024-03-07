<?php

declare(strict_types=1);

namespace App\Bpost\Services;

use App\Imports\Values\BpostUri;
use Illuminate\Support\Facades\Http;

final class DownloadMunicipalities
{
    private string $file;

    public function __construct(
        private BpostUri $uri = new BpostUri(),
    ) {
        dd((string) $this->uri);
        $this->file = Http::withOptions(['verify' => false])->get((string) $this->uri)->body();
    }
    
    public function get()
    {
        return $this->file;
    }
}