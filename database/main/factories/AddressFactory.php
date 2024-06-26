<?php

declare(strict_types=1);

namespace Database\Main\Factories;

use App\School\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'record_id' => $this->faker->randomNumber(3),
            'street_name' => $this->faker->name(),
            'street_identifier' => $this->faker->randomNumber(3) . ' ' . $this->faker->text(5),
            'municipality_id' => MunicipalityFactory::new()->withRegion()->create()->id,
        ];
    }

    public function withId(string $idString): self
    {
        return $this->state(['record_id' => $idString]);
    }
}
