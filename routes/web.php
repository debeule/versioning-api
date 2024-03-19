<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

use Http\Endpoints\TestHandler;

Route::get('/', TestHandler::class);
