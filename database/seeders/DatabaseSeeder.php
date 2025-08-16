<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\ServiceRequest;
use App\Models\User;
use Database\Factories\DeviceFactory;
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

        User::factory()
            ->getAdmin()
            ->create();

        $users = User::factory()
            ->count(15)
            ->create();

        $devices = Device::factory()
            ->count(9)
            ->create();

        ServiceRequest::factory()
            ->generateServiceRequests($users, $devices);
    }

}
