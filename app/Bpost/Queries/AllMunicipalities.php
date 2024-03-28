<?php

declare(strict_types=1);

namespace App\Bpost\Queries;

use App\Bpost\Municipality;
use App\Imports\Values\BpostUri;
use App\Imports\Values\MunicipalitiesUri;
use App\Services\ImportFileToStorage;
use App\Services\SpreadsheetToCollection;
use Illuminate\Support\Collection;
use App\Imports\Queries\ExternalMunicipalities;

final class AllMunicipalities implements ExternalMunicipalities
{
    private string $source, $storagePath;

    public function __construct()
    {
        $this->source = (string) new BpostUri;
        $this->storagePath = (string) new MunicipalitiesUri;
    }

    public function query(): Collection
    {
        if (config('tatooine.should_import')) 
        {
            ImportFileToStorage::setup($this->source, $this->storagePath)->pipe();
        }
        
        return SpreadsheetToCollection::setup($this->storagePath, Municipality::class)->pipe();
    }

    public function get(): Collection
    {
        try 
        {
            return $this->query();
        } 
        catch (\Throwable $th) 
        {
            dd($th);
        }
    }
}