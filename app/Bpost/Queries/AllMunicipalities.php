<?php

declare(strict_types=1);

namespace App\Bpost\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Excel;
use App\Bpost\Municipality;

final class AllMunicipalities
{
    private string $url = 'https://www.bpost2.be/zipcodes/files/zipcodes_alpha_nl_new.xls';

    public function query(): Array
    {
        // $this->importMunicipalitiesFile($this->url);

        $filePath = storage_path('app/municipalities.xls');
        $data = Excel::toArray([], $filePath, null, \Maatwebsite\Excel\Excel::XLS)[0];

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
                
                $municipality->name = $value[1];
                $municipality->postal_code = $value[0];
                $municipality->province = strtolower($value[4]);

                if ($value[2] === 'Ja') 
                {
                    $municipality->head_municipality = $value[3];
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

    public function importMunicipalitiesFile(string $url): bool
    {
        $file = Http::withOptions(['verify' => false])->get($url)->body();
        return Storage::disk('local')->put('municipalities.xlsx', $file);
    }
}