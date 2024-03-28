<?php


declare(strict_types=1);

namespace App\Sport\Commands;

use App\Imports\Queries\Sport;
use App\Sport\Sport as DbSport;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class CreateSport
{
    use DispatchesJobs;

    public function __construct(
        public Sport $sport
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->sport)->save();
    }

    public function buildRecord(Sport $sport): DbSport
    {
        $newSport = new DbSport();

        $newSport->record_id = $sport->recordId();
        $newSport->name = $this->sport->name();

        return $newSport;
    }
}