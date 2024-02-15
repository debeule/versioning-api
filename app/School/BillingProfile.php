<?php

declare(strict_types=1);

namespace App\School;

use Illuminate\Database\Eloquent\Model;

final class BillingProfile extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
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