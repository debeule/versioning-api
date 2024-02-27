<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Http\Endpoints\TestController;
use Illuminate\Routing\Router;

Route::get('/', TestController::class);
