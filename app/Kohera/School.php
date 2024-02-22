<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use App\Imports\Queries\School as SchoolContract;
use App\School\Address;
use Database\Kohera\Factories\SchoolFactory;
use App\Imports\Sanitizer\Sanitizer;

final class School extends Model implements SchoolContract
{
    public $timestamps = false;

    protected $connection = 'kohera-testing';

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
        return Sanitizer::input($this->id)->intValue();
    }
    
    public function sourceId(): string
    {
        return Sanitizer::input($this->place_id)->stringToLower()->value();
    }
    public function name(): string
    {
        return Sanitizer::input($this->Name)->stringToLower()->value();
    }

    public function email(): ?string
    {
        return Sanitizer::input($this->School_mail)->stringToLower()->value();
    }
    public function contactEmail(): ?string
    {
        return Sanitizer::input($this->Gangmaker_mail)->stringToLower()->value();
    }

    public function type(): string
    {
        return Sanitizer::input($this->Type)->stringToLower()->value();
    }

    public function schoolNumber(): string
    {
        return Sanitizer::input($this->School_Id)->stringToLower()->value();
    }

    public function institutionId(): int
    {
        return Sanitizer::input($this->Instellingsnummer)->intValue();
    }

    public function studentCount(): int
    {
        return  Sanitizer::input($this->Student_Count)->intValue();
    }

    public function address(): Address
    {
        return Address::where('address_id', 'school-' . $this->schoolId())->first();
    }
}