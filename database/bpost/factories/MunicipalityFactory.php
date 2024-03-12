<?php

declare(strict_types=1);

namespace Database\Bpost\Factories;

use App\Bpost\Municipality;
use App\Bpost\Commands\BuildMunicipalityRecord;
use Faker\Factory as FakerFactory;
use App\Imports\Values\ProvinceGroup;
use Illuminate\Support\Collection;

final class MunicipalityFactory
{
    public function __construct(
        private ?Municipality $municipality,
    ){}

    public static function new()
    {
        $faker = FakerFactory::create();

        return new self(new Municipality([
            $faker->randomNumber(4),
            $faker->city,
            $faker->city,
            'Ja',
            $faker->randomElement(ProvinceGroup::allProvinces()->get()),
        ]));
    }
    
    public function make(): Municipality
    {
        return $this->municipality;
    }

    public function count(int $times): collection
    {
        $collection = collect();

        for ($i = 0; $i < $times; $i++) 
        {
            $collection->push(MunicipalityFactory::new()->make());
        }

        return $collection;
    }
}
