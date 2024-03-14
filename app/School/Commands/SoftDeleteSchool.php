<?php


declare(strict_types=1);

namespace App\School\Commands;

use App\Kohera\School as KoheraSchool;
use App\School\School;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SoftDeleteSchool
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