<?php

namespace Database\Factories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Device::class;
    
    public function definition(): array
    {
        return [
            'model' => $this->faker->word(),
            'brand' => $this->faker->company(),
            'device_code' => strtoupper($this->faker->bothify('DEV-####')),
            'serial_number' => strtoupper($this->faker->bothify('SN-########')),
        ];
    }
}
