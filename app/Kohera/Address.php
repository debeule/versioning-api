<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Imports\Queries\Address as AddressContract;

final class Address extends Model implements AddressContract
{
    public function __construct(
        private School $school
    ) {}

    public function streetName(): string
    {
        return explode(' ', $this->school->address)[0];
    }

    public function streetIdentifier(): string
    {
        return explode(' ', $this->school->address)[1];
    }

    public function municipality(): Municipality
    {
        return Municipality::where('name', $this->school->Gemeente)->first();
    }
}