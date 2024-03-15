<?php


declare(strict_types=1);

namespace App\Location\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Location\Municipality;

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