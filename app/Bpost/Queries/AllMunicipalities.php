<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Kohera\School;
use App\School\Municipality;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

final class AllMunicipalities
{
    private string $url = 'https://www.bpost2.be/zipcodes/files/zipcodes_alpha_nl_new.xls';

    public function query(): Array
    {
        $this->importMunicipalitiesFile($this->url);
        
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
            try 
            {
                $municipality = new Municipality();
    
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

    public function importMunicipalitiesFile(string $url)
    {
        $file = Http::withOptions(['verify' => false])->get($url)->body();
        return Storage::disk('local')->put('municipalities.xlsx', $file);
    }
}