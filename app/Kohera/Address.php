<?php

declare(strict_types=1);

namespace App\Kohera;

use App\Imports\Queries\Address as AddressContract;
use App\Imports\Sanitizer\Sanitizer;
use App\Location\Municipality;
use App\School\Address as DbAddress;
use Illuminate\Database\Eloquent\Model;

final class Address extends Model implements AddressContract
{
    public function __construct(
        private School $school
    ) {}

    public function recordId(): string
    {
        return Sanitizer::input($this->record_id)->stringToLower()->value();
    }

    public function streetName(): string
    {
        return Sanitizer::input(explode(' ', $this->school->address)[0])->stringToLower()->value();
    }

    public function streetIdentifier(): string
    {
        return Sanitizer::input(explode(' ', $this->school->address)[1])->stringToLower()->value();
    }

    public function municipality(): Municipality
    {
        $postalCode = Sanitizer::input($this->school->Postcode)->value();
        
        return Municipality::where('postal_code', $postalCode)->first();
    }

    public function hasChanged(DbAddress $dbAddress): bool
    {
        $recordhasChanged = false;

        $recordhasChanged = $dbAddress->street_name !== $this->streetName();
        $recordhasChanged = $recordhasChanged || $dbAddress->street_identifier !== $this->streetIdentifier();

        return $recordhasChanged;
    }
}