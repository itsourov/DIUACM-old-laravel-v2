<?php

namespace App\Filament\Resources\UserSolveStatOnEventResource\Pages;

use App\Filament\Resources\UserSolveStatOnEventResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserSolveStatOnEvent extends EditRecord
{
    protected static string $resource = UserSolveStatOnEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
