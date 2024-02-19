<?php

declare(strict_types=1);

namespace App\Location;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Region extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'province',
        'region_id'
    ];

    public function subregions(): HasMany
    {
        return $this->hasMany(Region::class, 'region_id');
    }
}