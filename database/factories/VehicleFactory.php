<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        return [
            'brand' => fake()->randomElement(['BMW', 'Audi', 'Mercedes', 'Toyota']),
            'model' => fake()->word(),
            'vin' => fake()->unique()->regexify('[A-Z0-9]{17}'),
            'price' => fake()->numberBetween(10000, 100000),
            'year' => fake()->numberBetween(2015, 2024),
            'mileage' => fake()->optional()->numberBetween(0, 100000),
            'type' => fake()->randomElement(['new', 'used']),
        ];
    }

    public function newVehicle(): self
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'new',
            'mileage' => null,
        ]);
    }

    public function usedVehicle(): self
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'used',
            'mileage' => fake()->numberBetween(1000, 100000),
        ]);
    }
}
