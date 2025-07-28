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
            // 'model' => $this->faker->word(),
            // 'brand' => $this->faker->company(),
            // 'device_code' => strtoupper($this->faker->bothify('DEV-####')),
            // 'serial_number' => strtoupper($this->faker->bothify('SN-########')),
            
            'title' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'user_id' => User::factory(),
            'device_id' => Device::factory(),
            'status' => $this->faker->randomElement(['pending', 'done', 'canceled', 'in_progress']),
        ];
    }
}
