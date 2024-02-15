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
        if (!$this->recordExists($this->koheraSport)) 
        {
            return $this->buildRecord($this->koheraSport);
        }
        
        if ($this->recordExists($this->koheraSport) && $this->recordHasChanged($this->koheraSport)) 
        {
            return $this->createNewRecordVersion($this->koheraSport);
        }

        return true;
    }

    public function recordExists(KoheraSport $koheraSport): bool
    {
        return Sport::where('sport_id', $koheraSport->id())->exists();
    }

    public function buildRecord(): bool
    {
        $newSport = new Sport();

        $newSport->name = $this->koheraSport->name();

        return $newSport->save();
    }
}