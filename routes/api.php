<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use Http\Endpoints\Sport\AllSportsHandler;
use Http\Endpoints\Sport\SportByNameHandler;

use Http\Endpoints\Region\AllRegionsHandler;
use Http\Endpoints\Region\RegionByNameHandler;
use Http\Endpoints\Region\RegionByRegionNumberHandler;
use Http\Endpoints\Region\RegionByPostalCodeHandler;
use Http\Endpoints\Region\LinkedMunicipalitiesHandler;

use Http\Endpoints\School\AllSchoolsHandler;
use Http\Endpoints\School\SchoolByNameHandler;
use Http\Endpoints\School\SchoolByInstitutionIdHandler;

Route::prefix('v1')->group(function () 
{

    Route::prefix('sports')->group(function () 
    {
        Route::get('/all', AllSportsHandler::class);
        Route::get('/name/{name}', SportByNameHandler::class);
    });

    Route::prefix('regions')->group(function () 
    {
        Route::get('/all', AllRegionsHandler::class);
        Route::get('/name/{name}', RegionByNameHandler::class);
        Route::get('/region_number/{regionNumber}', RegionByRegionNumberHandler::class);
        Route::get('/postal_code/{postalCode}', RegionByPostalCodeHandler::class);
    });

    Route::prefix('schools')->group(function () 
    {
        Route::get('/all', AllSchoolsHandler::class);
        Route::get('/name/{name}', SchoolByNameHandler::class);
        Route::get('/institution_id/{institutionId}', SchoolByInstitutionIdHandler::class);
    });
});
