<?php

declare(strict_types=1);

namespace App\Bpost\Services;


use App\Bpost\Queries\RetrieveMunicipalitiesFromFile;
use App\Imports\Values\ProvinceGroup;

final class ImportMunicipalities
{
    private string $file;

    public function __construct(
        private ProvinceGroup $provinces = new ProvinceGroup(),
        private RetrieveMunicipalitiesFromFile $retrieveQuery = new RetrieveMunicipalitiesFromFile,
    ) {
        $this->file = $this->retrieveQuery->get();
    }

    public function get(): Object
    {
        $municipalities = collect();
        
        foreach ($file as $row => $column) 
        {
            $allowedProvinces = ['vlaams-brabant', 'west-vlaanderen', 'oost-vlaanderen', 'antwerpen', 'limburg'];

            if ($row == 0 || $column[4] == null) 
            {
                continue;
            }

            if ( ! in_array(strtolower($column[4]), $allowedProvinces)) 
            {
                continue;
            }
            
            try 
            {
                $municipality = new Municipality;
                
                $municipality->Plaatsnaam = $column[1];
                $municipality->Postcode = $column[0];
                $municipality->Provincie = strtolower($column[4]);

                if ($column[2] === 'Ja') 
                {
                    $municipality->Hoofdgemeente = $column[3];
                }
                
                $municipalities->push($municipality);
            } 

            catch (\Throwable $th) 
            {
                continue;
            }
        }

        return $municipalities;
    }
}