<?php

use App\Enums\ServiceRequestStatusType;
use App\Filament\Resources\ServiceRequests\Pages\CreateServiceRequest;
use App\Filament\Resources\ServiceRequests\Pages\ListServiceRequests;
use App\Models\Device;
use App\Models\ServiceRequest;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Testing\TestAction;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertModelMissing;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertTrue;

beforeEach(function (): void {
    $user = User::factory()->create();
    $this->userServiceRequests = ServiceRequest::factory()->count(10)->for($user)->create();
    
    actingAs($user);
});

test('user can only see their own service requests', function (): void {
    $allServiceRequests = ServiceRequest::factory()->count(10)->create();

    livewire(ListServiceRequests::class)
        ->assertOk()
        ->assertCanSeeTableRecords( $this->userServiceRequests)
        ->assertCanNotSeeTableRecords( $allServiceRequests)
        ->assertCountTableRecords(count($this->userServiceRequests))
        ->assertCanRenderTableColumn('title')
        ->assertCanRenderTableColumn('user.name')
        ->assertCanRenderTableColumn('device.serial_number')
        ->assertCanRenderTableColumn('status');
});

it('can search by service request title', function(): void {
    livewire(ListServiceRequests::class)
        ->assertOk()
        ->searchTable($this->userServiceRequests->first()->title)
        ->assertCanSeeTableRecords($this->userServiceRequests->where(['title', $this->userServiceRequests->first()->title]))
        ->assertCanNotSeeTableRecords($this->userServiceRequests->where(['title', '!=', $this->userServiceRequests->first()->title]));
});

it('can search service requests by user\'s name column', function(): void {
    livewire(ListServiceRequests::class)
        ->assertOk()
        ->searchTable($this->userServiceRequests->first()->user->name)
        ->assertCanSeeTableRecords($this->userServiceRequests->where(['user.name', $this->userServiceRequests->first()->user->name]))
        ->assertCanNotSeeTableRecords($this->userServiceRequests->where(['user.name', '!=', $this->userServiceRequests->first()->user->name]));
});

it('can search by device\'s serial number column', function(): void {
    livewire(ListServiceRequests::class)
        ->assertOk()
        ->searchTable($this->userServiceRequests->first()->device->serial_number)
        ->assertCanSeeTableRecords($this->userServiceRequests->where(['device.serial_number', $this->userServiceRequests->first()->device->serial_number]))
        ->assertCanNotSeeTableRecords($this->userServiceRequests->where(['device.serial_number', '!=', $this->userServiceRequests->first()->device->serial_number]));
});

it('can delete service requests', function(): void {
    $serviceRequests = $this->userServiceRequests;
    livewire(ListServiceRequests::class)
        ->assertCanSeeTableRecords($serviceRequests)
        ->selectTableRecords($serviceRequests)
        ->callAction(TestAction::make('delete')->table()->bulk())
        ->assertNotified()
        ->assertCanNotSeeTableRecords($serviceRequests);

    $serviceRequests->each(fn (ServiceRequest $serviceRequest) => assertDatabaseMissing($serviceRequest));
});