<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Database\Eloquent\Model;
use App\School\School as DbSchool;
use App\School\Address;
use App\Location\Municipality;
use App\School\BillingProfile;

final class School extends Model
{
    protected $fillable = [
        'name',
        'email',
        'contact_email',
        'type',
        'school_number',
        'institution_id',
        'student_count',
        'street_name',
        'street_identifier',
        'postal_code',
        'billing_name',
        'billing_email',
        'billing_vat',
        'billing_tav',
        'billing_street_name',
        'billing_street_identifier',
        'billing_postal_code',
    ];

    public static function build(DbSchool $dbSchool)
    {
        $school = new self();

        $school->addSchoolAttributes($dbSchool);
        $school->addAddressAttributes($dbSchool);
        $school->addBillingProfileAttributes($dbSchool);

        return $school;
    }

    public function addSchoolAttributes(DbSchool $dbSchool)
    {
        $this->name = $dbSchool->name;
        $this->email = $dbSchool->email;
        $this->contact_email = $dbSchool->contact_email;
        $this->type = $dbSchool->type;
        $this->school_number = $dbSchool->school_number;
        $this->institution_id = $dbSchool->institution_id;
        $this->student_count = $dbSchool->student_count;
    }

    public function addAddressAttributes(DbSchool $dbSchool)
    {
        $address = Address::where('id', $dbSchool->address_id)->first();

        $this->street_name = $address->street_name;
        $this->street_identifier = $address->street_identifier;
        $this->postal_code = Municipality::where('id', $address->municipality_id)->first()->postal_code;
    }

    public function addBillingProfileAttributes(DbSchool $dbSchool)
    {
        $billingProfile = BillingProfile::where('school_id', $dbSchool->id)->first();

        if (!is_null($billingProfile)) 
        {
            $this->billing_name = $billingProfile->name;
            $this->billing_email = $billingProfile->email;
            $this->billing_vat = $billingProfile->vat_number;
            $this->billing_tav = $billingProfile->tav;

            $this->addBillingProfileAddressAttributes($dbSchool);
        }
    }

    public function addBillingProfileAddressAttributes(DbSchool $dbSchool)
    {
        $address = Address::where('id', $dbSchool->address_id)->first();

        $this->billing_street_name = $address->street_name;
        $this->billing_street_identifier = $address->street_identifier;
        $this->billing_postal_code = Municipality::where('id', $address->municipality_id)->first()->postal_code;
    }
}