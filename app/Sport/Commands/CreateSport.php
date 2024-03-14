<?php


declare(strict_types=1);

namespace App\Sport\Commands;

use App\Kohera\Sport as KoheraSport;
use App\Sport\Sport;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class CreateSport
{
    use DispatchesJobs;

    public function __construct(
        public KoheraSport $koheraSport
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->koheraSport)->save();
    }

    public function buildRecord(KoheraSport $koheraSport): Sport
    {
        $newSport = new Sport();

        $newSport->record_id = $koheraSport->recordId();
        $newSport->name = $this->koheraSport->name();

        return $newSport;
    }
}