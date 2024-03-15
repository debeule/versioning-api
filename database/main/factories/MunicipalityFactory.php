<?php

declare(strict_types=1);

namespace Database\Main\Factories;

use App\Location\Municipality;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'record_id' => $this->faker->unique()->randomNumber(5),
            'name' => $this->faker->name(),
            'postal_code' => '2000',
            'province' => 'Antwerpen',
            'head_municipality' => 'Beerse',
            'region_id' => null,
        ];
    }

    public function withPostalCode(int $postalCode): self
    {
        return $this->state(['postal_code' => $postalCode]);
    }
    
    public function withRegion(): self
    {
        return $this->state(['region_id' => RegionFactory::new()->create()->id]);
    }
    
    public function withRegionId(int $id): self
    {
        return $this->state(['region_id' => $id]);
    }
}
