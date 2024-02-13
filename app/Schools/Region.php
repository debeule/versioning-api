<?php

declare(strict_types=1);

namespace App\Schools;

use Illuminate\Database\Eloquent\Model;

final class Region extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'province',
        'region_id'
    ];

    public function subregions()
    {
        return $this->hasMany(Region::class, 'region_id');
    }
}