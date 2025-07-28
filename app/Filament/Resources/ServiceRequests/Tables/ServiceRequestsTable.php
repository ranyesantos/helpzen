<?php

namespace App\Filament\Resources\ServiceRequests\Tables;

use App\Enums\ServiceRequestStatusType;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\IconColumn;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServiceRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Titulo'),

                TextColumn::make('user.name')
                    ->label('Aberto por:'),

                TextColumn::make('device.serial_number')
                    ->label('Dispositivo'),

                TextColumn::make('status')
                    ->size(TextSize::Large)
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        ServiceRequestStatusType::Pending->value => 'warning',
                        ServiceRequestStatusType::Done->value => 'success',
                        ServiceRequestStatusType::Canceled->value => 'danger',
                        ServiceRequestStatusType::In_Progress->value => 'info',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        ServiceRequestStatusType::Pending->value => __('Pendente'),
                        ServiceRequestStatusType::Done->value => __('Concluído'),
                        ServiceRequestStatusType::Canceled->value => __('Cancelado'),
                        ServiceRequestStatusType::In_Progress->value => __('Em Andamento'),
                    })
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
