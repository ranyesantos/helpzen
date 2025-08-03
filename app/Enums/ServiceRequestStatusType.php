<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ServiceRequestStatusType : string implements HasLabel, HasColor
{
    case Pending = 'pending';
    case Done = 'done';
    case Canceled = 'canceled';
    case In_Progress = 'in_progress';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pendente',
            self::Done => 'Concluído',
            self::Canceled => 'Cancelado',
            self::In_Progress => 'Em Andamento',
        };
    }

    public function getColor(): array
    {
        return match ($this) {
            self::Pending => Color::Yellow,
            self::Done => Color::Green,
            self::Canceled => Color::Red,
            self::In_Progress => Color::Blue,
        };
    }
}
