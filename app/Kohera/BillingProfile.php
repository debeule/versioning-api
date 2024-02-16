<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Imports\Queries\BillingProfile as BillingProfileContract;

final class BillingProfile extends Model implements BillingProfileContract
{
    public function __construct(
        private School $school
    ) {}
    
    public function billingProfileId(): int
    {
        return $this->school->id;
    }

    public function name(): string
    {
        return $this->school->Facturatie_Naam;
    }

    public function email(): string
    {
        return $this->school->Facturatie_Email;
    }

    public function vatNumber(): string
    {
        return $this->school->BTWNummer;
    }

    public function tav(): string
    {
        return $this->school->Facturatie_Tav;
    }

    public function address(): Address
    {
        return Address::where('school_id', $this->school->id)->first();
    }
    public function school(): School
    {
        return School::where('school_id', $this->school->id)->first();
    }
}