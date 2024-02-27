<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Http\Endpoints\Sport\AllSports;
use Http\Endpoints\Sport\SportByName;

use Http\Endpoints\Region\AllRegions;
use Http\Endpoints\Region\RegionByName;
use Http\Endpoints\Region\RegionByRegionNumber;
use Http\Endpoints\Region\RegionByPostalCode;
use Http\Endpoints\Region\LinkedMunicipalities;

use Http\Endpoints\School\AllSchools;
use Http\Endpoints\School\SchoolByName;
use Http\Endpoints\School\SchoolByInstitutionId;

Route::prefix('v1')->group(function () 
{
    Route::get('/sync', AllSports::class);

    Route::prefix('sports')->group(function () 
    {
        Route::get('/all', AllSports::class);
        Route::get('/name/{name}', SportByName::class);
    });

    Route::prefix('regions')->group(function () 
    {
        Route::get('/all', AllRegions::class);
        Route::get('/name/{name}', RegionByName::class);
        Route::get('/region_number/{regionNumber}', RegionByRegionNumber::class);
        Route::get('/postal_code/{postalCode}', RegionByPostalCode::class);
    });

    Route::prefix('schools')->group(function () 
    {
        Route::get('/all', AllSchools::class);
        Route::get('/name/{name}', SchoolByName::class);
        Route::get('/institution_id/{institutionId}', SchoolByInstitutionId::class);
    });
});
