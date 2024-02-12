<?php

declare(strict_types=1);

namespace Database\Kohera\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Kohera\Region;

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
            'RegionNaam' => $this->faker->city(),
            'Provincie' => $this->faker->state(),
            'Postcode' => $this->faker->postcode(),
            'RegioDetailId' => $this->faker->randomNumber(5)
        ];
    }
}
