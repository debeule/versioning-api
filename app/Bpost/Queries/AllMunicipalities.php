<?php

declare(strict_types=1);

namespace App\Bpost\Queries;

use App\Bpost\Queries\RetrieveMunicipalitiesFromBpost;
use App\Bpost\Commands\StoreMunicipalitiesFIle;
use App\Bpost\Services\MunicipalitiesFileToCollection;

final class AllMunicipalities
{
    public function __construct(
        private RetrieveMunicipalitiesFromBpost $download = new RetrieveMunicipalitiesFromBpost,
        private StoreMunicipalitiesFIle $store = new StoreMunicipalitiesFIle,
        private MunicipalitiesFileToCollection $import = new MunicipalitiesFileToCollection,
    ) {}

    public function query()
    {
        $this->store->store($this->download->get());
        
        return $this->import->get();
    }

    public function get()
    {
        return $this->query();
    }
}