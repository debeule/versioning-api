<?php

namespace App\Schools;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
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