<?php

namespace App\Filament\Resources\RankListResource\Pages;

use App\Filament\Resources\RankListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRankLists extends ListRecords
{
    protected static string $resource = RankListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
