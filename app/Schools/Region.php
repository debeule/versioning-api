<?php

declare(strict_types=1);

namespace App\Schools;

use Illuminate\Database\Eloquent\Model;

final class Region extends Model
{
    public $timestamps = false;

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