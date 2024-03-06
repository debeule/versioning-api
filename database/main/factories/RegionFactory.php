<?php

declare(strict_types=1);

namespace Database\Main\Factories;

use App\Location\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

final class RegionFactory extends Factory
{
    protected $model = Region::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'region_id' => $this->faker->randomNumber(3),
            'name' => $this->faker->name(),
            'region_number' => $this->faker->randomNumber(3),
        ];
    }
}
