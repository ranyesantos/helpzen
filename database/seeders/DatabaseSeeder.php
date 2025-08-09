<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $this->generateAdmin();
        $users = $this->generateCommomUser(15);

        $devices = $this->generateDevices(8);

        $this->generateServiceRequests($users, $devices);
    }

    private function generateServiceRequests($users, $devices): void
    {
        for ($i = 0; $i < rand(12, 28); $i++) {
            ServiceRequest::factory()
                ->forUser($users->random())
                ->forDevice($devices->random())
                ->create();
        }
    }

    private function generateDevices(int $q = 2): Collection
    {
        return Device::factory()
            ->count($q)
            ->create();
    }

    private function generateCommomUser(int $q = 2): Collection
    {
        return User::factory()
            ->count($q)
            ->create();
    }

    private function generateAdmin(): User
    {
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ])->assignRole('admin');

        return $user;
    }
}
