<?php

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DwhRegion extends Model
{
    public $timestamps = false;

    protected $connection = 'sqlite';

    use HasFactory;

    protected $fillable = [
        'RegionNaam',
        'Provincie',
        'Postcode',
        'RegioDetailId',
    ];
}