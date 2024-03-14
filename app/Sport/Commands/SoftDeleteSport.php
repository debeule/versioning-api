<?php


declare(strict_types=1);

namespace App\Sport\Commands;

use App\Kohera\Sport as KoheraSport;
use App\Sport\Sport;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SoftDeleteSport
{
    use DispatchesJobs;

    public function __construct(
        public Sport $sport
    ) {}

    public function handle(): bool
    {
        return $this->sport->delete();
    }
}