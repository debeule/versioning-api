<?php

declare(strict_types=1);

namespace App\School;

use Illuminate\Database\Eloquent\Model;
use App\Extensions\Eloquent\SoftDeletes
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'school_number',
        'institution_id',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }
}
