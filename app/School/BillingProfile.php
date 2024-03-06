<?php

declare(strict_types=1);

namespace App\School;

use App\Extensions\Eloquent\SoftDeletes\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class BillingProfile extends Model
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
        'email',
        'vat_number',
        'tav',
        'address_id',
        'school_id',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}