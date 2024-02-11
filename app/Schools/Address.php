<?php

declare(strict_types=1);

namespace App\Schools;

use Illuminate\Database\Eloquent\Model;

final class Address extends Model
{
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

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }
}