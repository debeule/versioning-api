<?php

declare(strict_types=1);

namespace App\School\Presentation;

use App\Location\Municipality;
use App\School\Address;
use App\School\BillingProfile;
use App\School\School as DbSchool;
use Illuminate\Database\Eloquent\Model;

final class School
{
    

    public static function new(): self
    {
        return new self();
    }

    public function build(DbSchool $dbSchool): self
    {
        $this->addSchoolAttributes($dbSchool);
        $this->addAddressAttributes($dbSchool);
        $this->addBillingProfileAttributes($dbSchool);

        return $this;
    }

    public function addSchoolAttributes(DbSchool $dbSchool): void
    {
        $this->name = $dbSchool->name;
        $this->email = $dbSchool->email;
        $this->contact_email = $dbSchool->contact_email;
        $this->type = $dbSchool->type;
        $this->school_number = $dbSchool->school_number;
        $this->institution_id = $dbSchool->institution_id;
        $this->student_count = $dbSchool->student_count;
    }

    public function addAddressAttributes(DbSchool $dbSchool): void
    {
        $address = Address::where('id', $dbSchool->address_id)->first();

        $this->street_name = $address->street_name;
        $this->street_identifier = $address->street_identifier;
        $this->postal_code = Municipality::where('id', $address->municipality_id)->first()->postal_code;
    }

    public function addBillingProfileAttributes(DbSchool $dbSchool): void
    {
        $billingProfile = BillingProfile::where('school_id', $dbSchool->id)->first();

        if (! is_null($billingProfile)) 
        {
            $this->billing_name = $billingProfile->name;
            $this->billing_email = $billingProfile->email;
            $this->billing_vat = $billingProfile->vat_number;
            $this->billing_tav = $billingProfile->tav;

            $this->addBillingProfileAddressAttributes($dbSchool);
        }
    }

    public function addBillingProfileAddressAttributes(DbSchool $dbSchool): void
    {
        $address = Address::where('id', $dbSchool->address_id)->first();

        $this->billing_street_name = $address->street_name;
        $this->billing_street_identifier = $address->street_identifier;
        $this->billing_postal_code = Municipality::where('id', $address->municipality_id)->first()->postal_code;
    }
}