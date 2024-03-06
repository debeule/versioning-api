<?php

declare(strict_types=1);

namespace App\School;

use App\Extensions\Eloquent\SoftDeletes\SoftDeletes;
use App\Location\Municipality;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class Address extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'street_name',
        'street_identifier',
        'email',
        'municipality_id',
    ];

    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    public function school(): HasOne
    {
        return $this->hasOne(School::class);
    }
}