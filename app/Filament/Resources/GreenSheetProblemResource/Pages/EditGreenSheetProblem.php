<?php

namespace App\Filament\Resources\GreenSheetProblemResource\Pages;

use App\Filament\Resources\GreenSheetProblemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGreenSheetProblem extends EditRecord
{
    protected static string $resource = GreenSheetProblemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
