<?php

declare(strict_types=1);

namespace App\Kohera;

use App\Imports\Queries\BillingProfile as BillingProfileContract;
use App\Imports\Sanitizer\Sanitizer;
use App\Kohera\School as KoheraSchool;
use App\School\Address;
use App\School\School;
use Illuminate\Database\Eloquent\Model;

final class BillingProfile extends Model implements BillingProfileContract
{
    public function __construct(
        private KoheraSchool $school
    ) {}
    
    public function recordId(): int
    {
        return Sanitizer::input($this->school->id)->intValue();
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

    public function hasChanged(Mixed $importedBillingProfile): bool
    {
        $recordHasChanged = false;

        $recordHasChanged = $recordHasChanged || $billingProfile->record_id !== $importedBillingProfile->recordId();
        $recordHasChanged = $recordHasChanged || $billingProfile->name !== $importedBillingProfile->name();
        $recordHasChanged = $recordHasChanged || $billingProfile->email !== $importedBillingProfile->email();
        $recordHasChanged = $recordHasChanged || $billingProfile->vat_number !== $importedBillingProfile->vatNumber();
        $recordHasChanged = $recordHasChanged || $billingProfile->tav !== $importedBillingProfile->tav();
        $recordHasChanged = $recordHasChanged || $billingProfile->address_id !== $importedBillingProfile->address()->id;
        $recordHasChanged = $recordHasChanged || $billingProfile->school_id !== $importedBillingProfile->school()->id;
        
        return $recordHasChanged;
    }
}