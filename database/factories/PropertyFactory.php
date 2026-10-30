<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Property>
 */
final class PropertyFactory extends Factory
{
    /**
     * An active Budapest rental office building.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $district = fake()->numberBetween(1, 23);

        return [
            'title' => fake()->unique()->company().' irodaház',
            'status' => PropertyStatus::Active,
            'elado_v_kiado' => PropertyType::Rent,
            'cim_irsz' => (string) (1000 + $district * 10 + fake()->numberBetween(1, 9)),
            'cim_varos' => 'Budapest',
            'cim_utca' => fake()->streetName(),
            'cim_hazszam' => fake()->buildingNumber().'.',
            'total_area' => fake()->numberBetween(1000, 40000),
            'min_berleti_dij' => fake()->numberBetween(10, 20),
            'max_berleti_dij' => fake()->numberBetween(20, 30),
            'min_berleti_dij_addons' => 'EUR/m2/hó',
            'featured' => false,
        ];
    }

    public function forSale(): self
    {
        return $this->state(['elado_v_kiado' => PropertyType::Sale]);
    }

    public function inactive(): self
    {
        return $this->state(['status' => PropertyStatus::Inactive]);
    }

    public function featured(): self
    {
        return $this->state(['featured' => true]);
    }
}
