<?php

declare(strict_types=1);

namespace App\Bpost\Queries;

use App\Imports\Values\BpostUri;
use Illuminate\Support\Facades\Http;

final class RetrieveMunicipalitiesFromBpost
{
    private string $file;

    public function __construct(
        private BpostUri $uri = new BpostUri(),
    ) {
        $this->file = Http::withOptions(['verify' => false])->get((string) $this->uri)->body();
    }
    
    public function get()
    {
        return $this->file;
    }
}