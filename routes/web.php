<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Http\Endpoints\Testhandler;
use Illuminate\Routing\Router;

Route::get('/', TestHandler::class);
