<?php


declare(strict_types=1);

namespace App\School\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;


final class SoftDeleteAddress
{
    use DispatchesJobs;

    public function __construct(
        public School $school
    ) {}

    public function handle(): bool
    {
        return $this->school->delete();
    }
}