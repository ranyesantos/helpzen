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
    $this->serviceRequests = ServiceRequest::factory()->count(10)->create();
    actingAs(User::factory()->create());
});

test('can see service requests list', function (): void {
    livewire(ListServiceRequests::class)
        ->assertOk()
        ->assertCanSeeTableRecords( $this->serviceRequests)
        ->assertCountTableRecords(count($this->serviceRequests))
        ->assertCanRenderTableColumn('title')
        ->assertCanRenderTableColumn('user.name')
        ->assertCanRenderTableColumn('device.serial_number')
        ->assertCanRenderTableColumn('status');
});

it('can search by service request title', function(): void {
    livewire(ListServiceRequests::class)
        ->assertOk()
        ->searchTable($this->serviceRequests->first()->title)
        ->assertCanSeeTableRecords($this->serviceRequests->where(['title', $this->serviceRequests->first()->title]))
        ->assertCanNotSeeTableRecords($this->serviceRequests->where(['title', '!=', $this->serviceRequests->first()->title]));
});

it('can search service requests by user\'s name column', function(): void {
    livewire(ListServiceRequests::class)
        ->assertOk()
        ->searchTable($this->serviceRequests->first()->user->name)
        ->assertCanSeeTableRecords($this->serviceRequests->where(['user.name', $this->serviceRequests->first()->user->name]))
        ->assertCanNotSeeTableRecords($this->serviceRequests->where(['user.name', '!=', $this->serviceRequests->first()->user->name]));
});

it('can search by device\'s serial number column', function(): void {
    livewire(ListServiceRequests::class)
        ->assertOk()
        ->searchTable($this->serviceRequests->first()->device->serial_number)
        ->assertCanSeeTableRecords($this->serviceRequests->where(['device.serial_number', $this->serviceRequests->first()->device->serial_number]))
        ->assertCanNotSeeTableRecords($this->serviceRequests->where(['device.serial_number', '!=', $this->serviceRequests->first()->device->serial_number]));
});

it('can delete service requests', function(): void {
    $serviceRequests = $this->serviceRequests;
    livewire(ListServiceRequests::class)
        ->assertCanSeeTableRecords($serviceRequests)
        ->selectTableRecords($serviceRequests)
        ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
        ->assertNotified()
        ->assertCanNotSeeTableRecords($serviceRequests);

    $serviceRequests->each(fn (ServiceRequest $serviceRequest) => assertDatabaseMissing($serviceRequest));
});