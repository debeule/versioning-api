<?php

declare(strict_types=1);

namespace App\School;

use App\Extensions\Eloquent\SoftDeletes\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
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
        'record_id',
        'name',
        'email',
        'contact_email',
        'type',
        'school_number',
        'institution_id',
        'student_count',
        'address_id',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }
}
