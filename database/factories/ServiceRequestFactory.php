<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceRequest>
 */
class ServiceRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'user_id' => User::factory(),
            'device_id' => Device::factory(),
            'status' => $this->faker->randomElement(['pending', 'done', 'canceled', 'in_progress']),
        ];
    }

    public function forUser(User $user): self
    {
        return $this->state(fn () => [
            'user_id' => $user->id
        ]);
    }

    public function forDevice(Device $device): self
    {
        return $this->state(fn () => [
            'device_id' => $device->id
        ]);
    }
}
