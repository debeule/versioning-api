<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use App\Imports\Queries\Address as AddressContract;
use App\Location\Municipality;
use App\Kohera\School;
use App\Imports\Sanitizer\Sanitizer;

final class Address extends Model implements AddressContract
{
    public function __construct(
        private School $school
    ) {}

    public function addressId(): string
    {
        return Sanitizer::input($this->address_id)->stringToLower()->value();
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
}