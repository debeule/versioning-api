<?php

declare(strict_types=1);

namespace App\Bpost\Queries;

use App\Bpost\Municipality;
use App\Imports\Queries\ExternalMunicipalities;
use App\Imports\Values\MunicipalitiesUrl;
use App\Services\ImportFileToStorage;
use App\Services\SpreadsheetToCollection;
use Illuminate\Support\Collection;

final class AllMunicipalities implements ExternalMunicipalities
{
    private string $storagePath;

    public function __construct(
        private string $source = 'www.bpost2.be/zipcodes/files/zipcodes_alpha_nl_new.xls',
    ){
        $this->storagePath = (string) new MunicipalitiesUrl;
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