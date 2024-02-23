<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Http\Controllers\TestController;
use Illuminate\Routing\Router;

Route::get('/', TestController::class);
