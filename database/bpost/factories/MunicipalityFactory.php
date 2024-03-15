<?php

declare(strict_types=1);

namespace Database\Bpost\Factories;

use App\Bpost\Municipality;
use App\Imports\Values\ProvinceGroup;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Collection;

final class MunicipalityFactory
{
    public function __construct(
        private Collection $municipalities,
    ){}

    public static function new()
    {
        $faker = FakerFactory::create();

        return new self(
            collect([
                new Municipality([
                    $faker->randomNumber(4),
                    $faker->city,
                    $faker->city,
                    'Ja',
                    $faker->randomElement(ProvinceGroup::allProvinces()->get()),
                ])
            ])
        );
    }

    public function count(int $times): self
    {
        for ($i = 0; $i < $times - 1; $i++) 
        {
            $this->municipalities->push($this->create());
        }

        return new self($this->municipalities);
        
    }

    public function create()
    {
        if($this->municipalities->count() === 1) 
        {
            return $this->municipalities->first();
        }

        return $this->municipalities;
    }

    public function createArray(): array
    {
        $outputArray = [];

        foreach ($this->municipalities as $municipality) 
        {
            array_push($outputArray, array_values((array) $municipality));
        }

        return $outputArray;
    }
}
