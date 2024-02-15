<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Imports\Queries\School as SchoolContract;
use App\School\Address;

final class School extends Model implements SchoolContract
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

    protected $casts = [
        'type' => 'string',
    ];
    
    public function sourceId(): string
    {
        return $this->place_id;
    }
    public function name(): string
    {
        return $this->Name;
    }

    public function email(): ?string
    {
        return $this->School_mail;
    }
    public function contactEmail(): ?string
    {
        return $this->Gangmaker_mail;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function schoolId(): string
    {
        return (string) $this->School_Id;
    }

    public function institutionId(): int
    {
        return $this->Instellingsnummer;
    }

    public function studentCount(): int
    {
        return $this->Student_Count;
    }

    public function address(): Address
    {
        return Address::where('street_name', explode(' ', $this->address)[0])->first();
    }
}