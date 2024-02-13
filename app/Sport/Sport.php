<?php

declare(strict_types=1);

namespace App\Sport;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Sport extends Model
{
    use SoftDeletes, HasFactory;

    protected static function newFactory()
    {
        return \Database\Main\Factories\SportFactory::new();
    }

    
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];
}
