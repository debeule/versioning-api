<?php

declare(strict_types=1);

namespace Database\Main\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Location\Municipality;

final class MunicipalityFactory extends Factory
{
    protected $model = Municipality::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'postal_code' => 2000,
            'province' => 'Antwerpen',
            'head_municipality' => 'Beerse',
            'region_id' => RegionFactory::new()->create()->id,
        ];
    }

    public function withPostalCode(int $postalCode): self
    {
        return $this->state(['postal_code' => $postalCode]);
    }
}
