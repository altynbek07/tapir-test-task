<?php

namespace Database\Factories;

use App\Models\Vehicle;
use App\Models\VehicleRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleRequestFactory extends Factory
{
    protected $model = VehicleRequest::class;

    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::factory(),
            'phone' => fake()->phoneNumber(),
            'crm_status' => fake()->randomElement(['pending', 'sent', 'failed']),
        ];
    }

    public function newStatus(): self
    {
        return $this->state(fn (array $attributes) => [
            'crm_status' => 'new',
        ]);
    }

    public function inProgressStatus(): self
    {
        return $this->state(fn (array $attributes) => [
            'crm_status' => 'in_progress',
        ]);
    }

    public function completedStatus(): self
    {
        return $this->state(fn (array $attributes) => [
            'crm_status' => 'completed',
        ]);
    }

    public function cancelledStatus(): self
    {
        return $this->state(fn (array $attributes) => [
            'crm_status' => 'cancelled',
        ]);
    }
}
