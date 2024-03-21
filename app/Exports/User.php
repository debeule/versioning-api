<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

final class User extends PersonalAccessToken
{
    use hasApiTokens;

    public $timestamps = false;
}