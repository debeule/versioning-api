<?php

declare(strict_types=1);

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;
use App\SoftDeletes\SoftDeletes;
use Database\Main\Factories\SportFactory;

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
        'sport_id',
        'name',
    ];
}
