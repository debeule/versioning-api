<?php

declare(strict_types=1);

namespace App\Schools;

use Illuminate\Database\Eloquent\Model;

final class BillingProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'address_id',
        'school_id',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}