<?php

namespace App\Filament\Resources\Devices\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DeviceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('model')
                    ->required()
                    ->minLength(2)
                    ->maxLength(255),

                TextInput::make('brand')
                    ->required()
                    ->minLength(2)
                    ->maxLength(255),

                TextInput::make('device_code')
                    ->required()
                    ->minLength(2)
                    ->maxLength(255),

                TextInput::make('serial_number')
                    ->required()
                    ->minLength(2)
                    ->maxLength(255),
            ]);
    }
}
