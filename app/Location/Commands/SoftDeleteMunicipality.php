<?php


declare(strict_types=1);

namespace App\Location\Commands;

use App\Location\Municipality;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SoftDeleteMunicipality
{
    use DispatchesJobs;

    public function __construct(
        public Municipality $municipality
    ) {}

    public function handle(): bool
    {
        return $this->municipality->delete();
    }
}