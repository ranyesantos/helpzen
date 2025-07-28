<?php

namespace App\Filament\Resources\ServiceRequests\Schemas;

use App\Models\Device;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ServiceRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
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

                Select::make('user_id')
                    ->required()
                    ->label('Usuário')
                    ->options(User::query()->pluck('name', 'id'))
                    ->searchable(),

                Select::make('device_id')
                    ->required()
                    ->label('Dispositivo')
                    ->options(Device::query()->pluck('serial_number', 'id'))
                    ->searchable()
            ]);
    }
}
