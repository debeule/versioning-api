<?php

declare(strict_types=1);

namespace App\Sport;

use App\Extensions\Eloquent\SoftDeletes\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

final class Sport extends Model
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
    ];
}
