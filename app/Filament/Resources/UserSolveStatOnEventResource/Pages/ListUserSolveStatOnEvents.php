<?php

namespace App\Filament\Resources\UserSolveStatOnEventResource\Pages;

use App\Filament\Resources\UserSolveStatOnEventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserSolveStatOnEvents extends ListRecords
{
    protected static string $resource = UserSolveStatOnEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
