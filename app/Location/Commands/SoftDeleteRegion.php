<?php


declare(strict_types=1);

namespace App\Location\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;

final class SoftDeleteRegion
{
    use DispatchesJobs;

    public function __construct(
        public Sport $Region
    ) {}

    public function handle(): bool
    {
        return $this->Region->delete();
    }
}