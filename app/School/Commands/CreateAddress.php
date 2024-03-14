<?php


declare(strict_types=1);

namespace App\School\Commands;

use App\Kohera\Address as KoheraAddress;
use App\School\Address;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Location\Municipality;

final class CreateAddress
{
    use DispatchesJobs;

    public function __construct(
        public KoheraAddress $koheraAddress
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->koheraAddress)->save();
    }   

    private function buildRecord(KoheraAddress $koheraAddress): Address
    {
        $newAdress = new Address();
        
        $newAdress->record_id = $koheraAddress->recordId();
        $newAdress->street_name = $koheraAddress->streetName();
        $newAdress->street_identifier = $koheraAddress->streetIdentifier();
        
        $newAdress->municipality_id = Municipality::where('postal_code', $koheraAddress->municipality()->postal_code)->first()->id;

        return $newAdress;
    }
}