<?php

namespace App\Filament\Resources\ServiceRequests\Schemas;

use App\Enums\ServiceRequestStatusType;
use App\Models\Device;
use App\Models\User;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class ServiceRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([            
                Group::make([
                    TextInput::make('title')
                        ->required()
                        ->minLength(2)
                        ->maxLength(255)
                        ->label('Titulo'),
    
                    Textarea::make('description')
                        ->required()
                        ->minLength(2)
                        ->maxLength(255)
                        ->label('Descrição')
                        ->rows(4),
    
                    Group::make([
                        Hidden::make('user_id')
                            ->label('Aberto por:')
                            ->default(Auth::user()->id),
        
                        Select::make('device_id')
                            ->required()
                            ->label('Dispositivo')
                            ->options(Device::query()->pluck('serial_number', 'id'))
                            ->searchable(),

                        Select::make('status')
                            ->label('Status')
                            ->options(ServiceRequestStatusType::class)
                            ->default(ServiceRequestStatusType::Pending)
                            ->hiddenOn('create')
                    ])->columns(3)
                ])->columnSpan(2)
            ]);
    }
}
