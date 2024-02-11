<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Http\Controllers\RetrieveDataController;
use Http\Controllers\TestController;
use Illuminate\Routing\Router;

Route::get('/', TestController::class);

// localhost/v1/Sports/?name=foodball&version=2024-01-01T10:00:00+00:00
// api/v1/Sports/?name=foodball&version=2024-01-01T10:00:00+00:00


Route::prefix('v1')->group(function () {
    Route::get('/{domain}', RetrieveDataController::class);
});
