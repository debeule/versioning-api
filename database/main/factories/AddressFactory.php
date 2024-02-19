<?php

declare(strict_types=1);

namespace Database\Main\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\School\Address;

final class AddressFactory extends Factory
{
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'address_id' => $this->faker->randomNumber(3),
            'street_name' => $this->faker->name(),
            'street_identifier' => $this->faker->randomNumber(3) . ' ' . $this->faker->text(5),
            'municipality_id' => MunicipalityFactory::new()->create()->id,
        ];
    }

    public function withId(string $idString): self
    {
        return $this->state(['address_id' => $idString]);
    }
}
