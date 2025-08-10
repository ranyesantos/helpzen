<?php

namespace App\Filament\Resources\ServiceRequests\Schemas;

use App\Enums\ServiceRequestStatusType;
use App\Models\Device;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

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
                        Select::make('user_id')
                            ->required()
                            ->label('Aberto por:')
                            ->options(User::query()->pluck('name', 'id'))
                            ->searchable(),
        
                        Select::make('device_id')
                            ->required()
                            ->label('Dispositivo')
                            ->options(Device::query()->pluck('serial_number', 'id'))
                            ->searchable(),

                        Select::make('status')
                            ->label('Status')
                            ->options(ServiceRequestStatusType::class)
                    ])->columns(3)
                ])->columnSpan(2)
            ]);
    }
}
