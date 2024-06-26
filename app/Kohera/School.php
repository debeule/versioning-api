<?php

declare(strict_types=1);

namespace App\Kohera;

use App\Imports\Queries\School as SchoolContract;
use App\Imports\Sanitizer\Sanitizer;
use App\School\Address;
use App\School\School as DbSchool;
use Illuminate\Database\Eloquent\Model;

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

    public function recordId(): int
    {
        return Sanitizer::input($this->id)->numericValue();
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
        return Sanitizer::input($this->Instellingsnummer)->numericValue();
    }

    public function studentCount(): int
    {
        return  Sanitizer::input($this->Student_Count)->numericValue();
    }

    public function address(): Address
    {
        return Address::where('record_id', 'school-' . $this->recordId())->first();
    }
    
    public function hasChanged(DbSchool $dbSchool): bool
    {
        $recordhasChanged = false;

        $recordhasChanged = $dbSchool->name !== $this->name();
        $recordhasChanged = $recordhasChanged || $dbSchool->email !== $this->email();
        $recordhasChanged = $recordhasChanged || $dbSchool->contact_email !== $this->contactEmail();
        $recordhasChanged = $recordhasChanged || $dbSchool->type !== $this->type();
        $recordhasChanged = $recordhasChanged || $dbSchool->school_number !== $this->schoolNumber();
        $recordhasChanged = $recordhasChanged || $dbSchool->institution_id !== $this->institutionId();
        $recordhasChanged = $recordhasChanged || $dbSchool->student_count !== $this->studentCount();

        return $recordhasChanged;
    }
}