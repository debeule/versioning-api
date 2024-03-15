<?php


declare(strict_types=1);

namespace App\Location\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Location\Region;

final class SoftDeleteRegion
{
    use DispatchesJobs;

    public function __construct(
        public Region $Region
    ) {}

    public function handle(): bool
    {
        return $this->Region->delete();
    }
}