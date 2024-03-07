<?php

declare(strict_types=1);

namespace App\Bpost\Services;

use App\Bpost\Queries\RetrieveMunicipalitiesFromFile;
use App\Imports\Values\ProvinceGroup;
use App\Bpost\Commands\BuildMunicipalityRecord;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class MunicipalitiesFileToCollection
{
    use DispatchesJobs;

    private array $fileArray = [];
    private array $allowedProvinces = [];

    public function __construct(
        private ProvinceGroup $provinceGroup = new ProvinceGroup(),
        private RetrieveMunicipalitiesFromFile $retrieveMunicipalitiesFromFileQuery = new RetrieveMunicipalitiesFromFile,
    ) {
        $this->fileArray = $this->retrieveMunicipalitiesFromFileQuery->get();
        $this->allowedProvinces = $this->provinceGroup->allProvinces()->get();
    }

    public function get(): Object
    {
        $municipalities = collect();
        
        foreach ($this->fileArray as $row => $column) 
        {
            if ($this->rowIsValid($column)) 
            {
                $municipalities->push(BuildMunicipalityRecord::build($column)->get());
            }
        }

        return $municipalities;
    }

    private function rowIsValid(array $column): bool
    {
        if ($column[4] == null) 
        {
            return false;
        }

        if (!in_array(strtolower($column[4]), $this->allowedProvinces)) 
        {
            return false;
        }

        return true;
    }
}