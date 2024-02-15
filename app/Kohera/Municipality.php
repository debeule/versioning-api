<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Municipality extends Model
{
    public function __construct(
        private School $school
    ) {}

    public function name(): string
    {
        return $this->school->Gemeente;
    }

    public function postalCode(): int
    {
        return $this->school->Postcode;
    }

    public function region(): Region
    {
        return Region::where('name', $this->school->RegioDetailId)->first();
    }
}