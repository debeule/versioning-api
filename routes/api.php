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
    //     Route::get('/sport_id/{value}', SportsBySportId::class);
    //     Route::get('/name/{value}', SportsByName::class);
    });

    // Route::prefix('schools')->group(function () 
    // {
    //     Route::get('/all', AllSchools::class);
    //     Route::get('/school_id/{value}', SchoolsBySchoolId::class);
    //     Route::get('/name/{value}', SchoolsByName::class);
    //     Route::get('/email/{value}', SchoolsByEmail::class);
    //     Route::get('/contact_email/{value}', SchoolsByContactEmail::class);
    //     Route::get('/type/{value}', SchoolByType::class);
    //     Route::get('/school_number/{value}', SchoolsBySchoolNumber::class);
    //     Route::get('/institution_id/{value}', SchoolsByInstitutionId::class);
    //     Route::get('/student_count/{value}', SchoolsByStudentCount::class);
    // });
});
