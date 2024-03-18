<?php


declare(strict_types=1);

namespace App\Location\Commands;

use App\Location\Region;
use Illuminate\Foundation\Bus\DispatchesJobs;

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