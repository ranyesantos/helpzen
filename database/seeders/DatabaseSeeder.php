<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\ServiceRequest;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        Device::factory()->count(20)->create();
        ServiceRequest::factory()->count(20)->create();
    }
}
