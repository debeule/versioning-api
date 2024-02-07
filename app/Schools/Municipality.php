<?php

namespace App\Schools;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Municipality extends Model
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
        'school_id',
        'institution_id',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
