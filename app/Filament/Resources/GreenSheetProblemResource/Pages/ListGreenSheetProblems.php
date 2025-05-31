<?php

namespace App\Filament\Resources\GreenSheetProblemResource\Pages;

use App\Filament\Resources\GreenSheetProblemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGreenSheetProblems extends ListRecords
{
    protected static string $resource = GreenSheetProblemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
