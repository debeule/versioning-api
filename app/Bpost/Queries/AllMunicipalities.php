<?php

declare(strict_types=1);

namespace App\Bpost\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Excel;
use App\Bpost\Municipality;
use Illuminate\Support\Facades\File;

final class AllMunicipalities
{
    public function query(): Array
    {
        if (config('import_municipalities'))
        {
            $this->importMunicipalitiesFile();
        }

        $filePath = storage_path('app/municipalities.xlsx');
        $data = Excel::toArray([], $filePath, null, \Maatwebsite\Excel\Excel::XLSX)[0];

        return $data;
    }

    public function get(): Object
    {
        $data = $this->query();
        
        $municipalities = collect();
        
        foreach ($data as $key => $value) 
        {
            $allowedProvinces = ['vlaams-brabant', 'west-vlaanderen', 'oost-vlaanderen', 'antwerpen', 'limburg'];

            if ($key == 0 || $value[4] === null) 
            {
                continue;
            }

            if ( !in_array(strtolower($value[4]), $allowedProvinces)) 
            {
                continue;
            }
            
            try 
            {
                $municipality = new Municipality;
                
                $municipality->Plaatsnaam = $value[1];
                $municipality->Postcode = $value[0];
                $municipality->Provincie = strtolower($value[4]);

                if ($value[2] === 'Ja') 
                {
                    $municipality->Hoofdgemeente = $value[3];
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

    public function importMunicipalitiesFile(): bool
    {
        $url = 'https://www.bpost2.be/zipcodes/files/zipcodes_alpha_nl_new.xls';
        $filePath = 'municipalities.xlsx';

        $file = Http::withOptions(['verify' => false])->get($url)->body();

        if (File::exists($filePath)) 
        {
            File::delete($filePath);
        }

        return Storage::disk('local')->put($filePath, $file);
    }
}