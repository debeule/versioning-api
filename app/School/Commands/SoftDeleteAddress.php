<?php


declare(strict_types=1);

namespace App\School\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;
use App\School\Address;

final class SoftDeleteAddress
{
    use DispatchesJobs;

    public function __construct(
        public Address $address
    ) {}

    public function handle(): bool
    {
        return $this->address->delete();
    }
}