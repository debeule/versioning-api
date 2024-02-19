<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Imports\Queries\School as SchoolContract;
use App\School\Address;
use Database\Kohera\Factories\SchoolFactory;

final class School extends Model implements SchoolContract
{
    public $timestamps = false;

    protected $connection = 'kohera-testing';

    use HasFactory;

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

    public function schoolId(): int
    {
        return $this->id;
    }
    
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
        return $this->Type;
    }

    public function schoolNumber(): string
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
        return Address::where('address_id', $this->id)->first();
    }
}