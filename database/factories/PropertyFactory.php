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
            'offer_type' => PropertyType::Rent,
            'postal_code' => (string) (1000 + $district * 10 + fake()->numberBetween(1, 9)),
            'city' => 'Budapest',
            'street' => fake()->streetName(),
            'house_number' => fake()->buildingNumber().'.',
            'total_area' => (string) fake()->numberBetween(1000, 40000),
            'min_rent' => (string) fake()->numberBetween(10, 20),
            'max_rent' => (string) fake()->numberBetween(20, 30),
            'min_rent_unit' => 'EUR/m2/hó',
            'featured' => false,
        ];
    }

    public function forSale(): self
    {
        return $this->state(['offer_type' => PropertyType::Sale]);
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
