<?php

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DwhRegion extends Model
{
    public $timestamps = false;
    
    use HasFactory;

    protected $fillable = [
        'RegionNaam',
        'Provincie',
        'Postcode',
        'RegioDetailId',
    ];
}