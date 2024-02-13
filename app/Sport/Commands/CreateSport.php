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
        $newSport = new Sport();

        $newSport->name = $koheraSport->Sportkeuze;

        return $newSport->save();
    }
}