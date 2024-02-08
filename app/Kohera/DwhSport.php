<?php

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DwhSport extends Model
{
    public $timestamps = false;

    protected $connection = 'sqlite';

    use HasFactory;

    protected $fillable = [
        'Sportkeuze',
        'BK_SportTakSportOrganisatie',
        'Sport',
        'Hoofdsport',
    ];
}