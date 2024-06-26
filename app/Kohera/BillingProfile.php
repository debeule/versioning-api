<?php

declare(strict_types=1);

namespace App\Kohera;

use App\Imports\Queries\BillingProfile as BillingProfileContract;
use App\Imports\Sanitizer\Sanitizer;
use App\Kohera\School as KoheraSchool;
use App\School\Address;
use App\School\BillingProfile as DbBillingProfile;
use App\School\School;
use Illuminate\Database\Eloquent\Model;

final class BillingProfile extends Model implements BillingProfileContract
{
    public function __construct(
        private KoheraSchool $school
    ) {}
    
    public function recordId(): int
    {
        return Sanitizer::input($this->school->id)->numericValue();
    }

    public function name(): string
    {
        return Sanitizer::input($this->school->Facturatie_Naam)->value();
    }

    public function email(): string
    {
        return Sanitizer::input($this->school->Facturatie_Email)->value();
    }

    public function vatNumber(): string
    {
        return Sanitizer::input($this->school->BTWNummer)->value();
    }

    public function tav(): string
    {
        return Sanitizer::input($this->school->Facturatie_Tav)->stringToLower()->value();
    }

    public function address(): Address
    {
        return Address::where('record_id', 'billing_profile-' . $this->recordId())->first();
    }
    
    public function school(): School
    {
        return School::where('record_id', $this->recordId())->first();
    }

    public function hasChanged(DbBillingProfile $dbBillingProfile): bool
    {
        $recordHasChanged = false;

        $recordHasChanged = $dbBillingProfile->record_id !== $this->recordId();
        $recordHasChanged = $recordHasChanged || $dbBillingProfile->name !== $this->name();
        $recordHasChanged = $recordHasChanged || $dbBillingProfile->email !== $this->email();
        $recordHasChanged = $recordHasChanged || $dbBillingProfile->vat_number !== $this->vatNumber();
        $recordHasChanged = $recordHasChanged || $dbBillingProfile->tav !== $this->tav();
        $recordHasChanged = $recordHasChanged || $dbBillingProfile->address_id !== $this->address()->id;
        $recordHasChanged = $recordHasChanged || $dbBillingProfile->school_id !== $this->school()->id;
        
        return $recordHasChanged;
    }
}