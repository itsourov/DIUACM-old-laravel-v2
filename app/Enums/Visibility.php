<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Visibility: string implements HasColor, HasIcon, HasLabel
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';

    public function getColor(): string
    {
        return match ($this) {
            self::DRAFT => 'info',
            self::PUBLISHED => 'success'
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PUBLISHED => 'Published'
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::DRAFT => 'heroicon-o-clock',
            self::PUBLISHED => 'heroicon-o-check-badge',
        };
    }

    public static function toArray(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
