<?php

declare(strict_types=1);

namespace App\Exports;

use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

final class User extends PersonalAccessToken
{
    use hasApiTokens;

    public $timestamps = false;
}