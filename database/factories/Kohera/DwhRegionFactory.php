<?php

declare(strict_types=1);

namespace Database\Factories\Kohera;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Kohera\DwhRegion;

final class DwhRegionFactory extends Factory
{
    protected $model = DwhRegion::class;

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
