<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Sport extends Model
{
    public $timestamps = false;

    protected $connection = 'sqlite';

    use HasFactory;
    
    protected static function newFactory()
    {
        return \Database\Kohera\Factories\SportFactory::new();
    }

    protected $fillable = [
        'Sportkeuze',
        'BK_SportTakSportOrganisatie',
        'Sport',
        'Hoofdsport',
    ];
}