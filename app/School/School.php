<?php

declare(strict_types=1);

namespace App\School;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class School extends Model
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
        'type',
        'schoolNumber',
        'institution_id',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
