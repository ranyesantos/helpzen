<?php

use App\Enums\ServiceRequestStatusType;
use App\Filament\Resources\ServiceRequests\Pages\CreateServiceRequest;
use App\Models\Device;
use App\Models\ServiceRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertTrue;

describe ('user creating', function() {
    it('should be able to create a service request as common user', function (): void {
        $user = User::factory()->create();
        $device = Device::factory()->create();
        $input = [
            'title' => 'service request title',
            'description' => 'service request description',
            'user_id' => $user->id,
            'device_id' => $device->id,
            'status' => ServiceRequestStatusType::Pending->value
        ];
    
        actingAs($user);
        
        livewire(CreateServiceRequest::class)
            ->fillForm($input)
            ->call('create')
            ->assertSuccessful()
            ->assertHasNoErrors();
        
        assertDatabaseCount(ServiceRequest::class, 1);
        assertDatabaseHas(ServiceRequest::class,$input);
    });
    
    it('should be able to create a service request as admin user', function (): void {
        Role::create(['name' => 'admin']);
        $admin = User::factory()->create()->assignRole('admin');
        $device = Device::factory()->create();
        $input = [
            'title' => 'service request title',
            'description' => 'service request description',
            'user_id' => $admin->id,
            'device_id' => $device->id,
            'status' => ServiceRequestStatusType::Pending->value
        ];
        assertTrue($admin->hasRole('admin'));
    
        actingAs($admin);
    
        livewire(CreateServiceRequest::class)
            ->fillForm($input)
            ->call('create')
            ->assertSuccessful()
            ->assertHasNoErrors();
    
        assertDatabaseCount(ServiceRequest::class, 1);
        assertDatabaseHas(ServiceRequest::class, $input);
    });

    
});    

