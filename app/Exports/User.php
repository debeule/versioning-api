<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenthicatable;

final class User extends Authenthicatable
{
    use hasApiTokens

    
}