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

    public function __construct(
        private RetrieveMunicipalitiesFromFile $retrieveMunicipalitiesFromFileQuery = new RetrieveMunicipalitiesFromFile,
    ) {
        $this->fileArray = $this->retrieveMunicipalitiesFromFileQuery->get();
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

        if (!in_array(strtolower($column[4]), provinceGroup::allProvinces()->get())) 
        {
            return false;
        }

        return true;
    }
}