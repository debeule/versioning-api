<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Http\Controllers\SportControllers\AllSports;
use Http\Controllers\SportControllers\SportByName;

use Http\Controllers\RegionControllers\AllRegions;
use Http\Controllers\RegionControllers\RegionByName;
use Http\Controllers\RegionControllers\RegionByRegionNumber;
use Http\Controllers\RegionControllers\RegionByPostalCode;
use Http\Controllers\RegionControllers\LinkedMunicipalities;

use Http\Controllers\SchoolControllers\AllSchools;
use Http\Controllers\SchoolControllers\SchoolByName;
use Http\Controllers\SchoolControllers\SchoolByInstitutionId;

Route::prefix('v1')->group(function () 
{
    Route::get('/sync', AllSports::class);

    Route::prefix('sports')->group(function () 
    {
        Route::get('/all', AllSports::class);
        Route::get('/name/{value}', SportByName::class);
    });

    Route::prefix('regions')->group(function () 
    {
        Route::get('/all', AllRegions::class);
        Route::get('/name/{value}', RegionByName::class);
        Route::get('/region_number/{value}', RegionByRegionNumber::class);
        Route::get('/postal_code/{value}', RegionByPostalCode::class);
        Route::get('/linked_municipalities/{value}', LinkedMunicipalities::class);
    });

    Route::prefix('schools')->group(function () 
    {
        Route::get('/all', AllSchools::class);
        Route::get('/name/{value}', SchoolByName::class);
        Route::get('/institution_id/{value}', SchoolByInstitutionId::class);
    });
});
