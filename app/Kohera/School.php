<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class School extends Model
{
    public $timestamps = false;

    protected $connection = 'kohera-testing';

    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Kohera\Factories\SchoolFactory::new();
    }

    protected $fillable = [
        'place_id',
        'Name',
        'Gangmaker_mail',
        'School_mail',
        'address',
        'Student_Count',
        'School_Id',
        'Instellingsnummer',
        'Postcode',
        'Gemeente',
        'type',
        'Facturatie_Naam',
        'Facturatie_Tav',
        'Facturatie_Adres',
        'Facturatie_Postcode',
        'Facturatie_Gemeente',
        'BTWNummer',
        'Facturatie_Email',
    ];
}