<?php

namespace App\Filament\Resources\GreenSheetProblemResource\Pages;

use App\Filament\Resources\GreenSheetProblemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGreenSheetProblem extends CreateRecord
{
    protected static string $resource = GreenSheetProblemResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
