<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ContestType: string implements HasColor, HasIcon, HasLabel
{
    case ICPC_REGIONAL = 'icpc_regional';
    case ICPC_ASIA_WEST = 'icpc_asia_west';
    case IUPC = 'iupc';
    case OTHER = 'other';

    public function getColor(): string
    {
        return match ($this) {
            self::ICPC_REGIONAL => 'info',
            self::ICPC_ASIA_WEST => 'success',
            self::IUPC => 'primary',
            self::OTHER => 'warning'
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::ICPC_REGIONAL => 'ICPC Regional',
            self::ICPC_ASIA_WEST => 'ICPC Asia West',
            self::IUPC => 'IUPC',
            self::OTHER => 'Other'
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ICPC_REGIONAL => 'heroicon-o-globe-alt',
            self::ICPC_ASIA_WEST => 'heroicon-o-map',
            self::IUPC => 'heroicon-o-light-bulb',
            self::OTHER => 'heroicon-o-information-circle',
        };
    }

    public static function toArray(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
