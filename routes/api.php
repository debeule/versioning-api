<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Http\Controllers\AllSports;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () 
{
    Route::prefix('sports')->group(function () 
    {
        Route::get('/all', AllSports::class);
        Route::get('/name/{value}', SportsByName::class);
    });

    Route::prefix('regions')->group(function () 
    {
        Route::get('/all', AllRegions::class);
        Route::get('/name/{value}', RegionByName::class);
        Route::get('/region_number/{value}', RegionByRegionNumber::class);
        Route::get('/linked_municipality/{value}', RegionByLinkedMunicipality::class);
        Route::get('/linked_municipalities/{value}', AllLinkedMunicipalities::class);
    });

    Route::prefix('schools')->group(function () 
    {
        Route::get('/all', AllSchools::class);
        Route::get('/name/{value}', SchoolByName::class);
        Route::get('/institution_id/{value}', SchoolByInstitutionId::class);
    });
});
