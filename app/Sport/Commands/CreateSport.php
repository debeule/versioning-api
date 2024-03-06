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
        if (! $this->recordExists($this->koheraSport)) 
        {
            return $this->buildRecord($this->koheraSport);
        }
        
        if ($this->recordHasChanged($this->koheraSport)) 
        {
            return $this->createNewRecordVersion($this->koheraSport);
        }

        return false;
    }

    public function recordExists(KoheraSport $koheraSport): bool
    {
        return Sport::where('sport_id', $koheraSport->sportId())->exists();
    }

    public function buildRecord(KoheraSport $koheraSport): bool
    {
        $newSport = new Sport();

        $newSport->sport_id = $koheraSport->sportId();
        $newSport->name = $this->koheraSport->name();

        return $newSport->save();
    }

    public function recordHasChanged(KoheraSport $koheraSport): bool
    {
        $sport = Sport::where('sport_id', $koheraSport->sportId())->first();

        return $sport->name !== $koheraSport->name();
    }

    public function createNewRecordVersion(KoheraSport $koheraSport): bool
    {
        $sport = Sport::where('sport_id', $koheraSport->sportId())->first();
        $sport->delete();

        $newSport = new Sport();

        $newSport->sport_id = $koheraSport->sportId();
        $newSport->name = $koheraSport->name();

        return $newSport->save();
    }
}