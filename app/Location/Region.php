<?php

declare(strict_types=1);

namespace App\Location;

use App\Extensions\Eloquent\SoftDeletes\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Region extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'record_id',
        'name',
        'region_number',
    ];

    public function municipalities(): HasMany
    {
        return $this->hasMany(Municipality::class);
    }
}