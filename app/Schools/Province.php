<?php

declare(strict_types=1);

namespace App\Schools;

use Illuminate\Database\Eloquent\Model;

final class Province extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function regions()
    {
        return $this->hasMany(Region::class);
    }
}