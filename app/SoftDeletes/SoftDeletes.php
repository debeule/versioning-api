<?php

declare(strict_types=1);

namespace App\SoftDeletes;

use Illuminate\Database\Eloquent\SoftDeletes as BaseSoftDeletes;
use App\Models\Scopes\SoftDeletingWithDeletesScope;

trait SoftDeletes
{
    use BaseSoftDeletes;

    public static function bootSoftDeletes()
    {
        static::addGlobalScope(new SoftDeletingScope);
    }
}