<?php

namespace App\Schools;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [
        'name',
        'region_id',
        'province_id',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function subregions()
    {
        return $this->hasMany(Region::class, 'region_id');
    }
}