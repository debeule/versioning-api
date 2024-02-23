<?php

declare(strict_types=1);

namespace App\Location;

use Illuminate\Database\Eloquent\Model;
use App\SoftDeletes\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Municipality extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'postal_code',
        'province',
        'head_municipality',
        'region_id',
    ];

    public function address(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function region() : BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
