<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use App\Imports\Queries\BillingProfile as BillingProfileContract;
use App\School\Address;
use App\School\School;
use App\Kohera\School as KoheraSchool;

final class BillingProfile extends Model implements BillingProfileContract
{
    public function __construct(
        private KoheraSchool $school
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
        return (string) $this->school->BTWNummer;
    }

    public function tav(): string
    {
        return (string) $this->school->Facturatie_Tav;
    }

    public function address(): Address
    {
        return Address::where('address_id', 'billing_profile-' . $this->school->id)->first();
    }
    
    public function school(): School
    {
        return School::where('school_id', (int) $this->school->id)->first();
    }
}