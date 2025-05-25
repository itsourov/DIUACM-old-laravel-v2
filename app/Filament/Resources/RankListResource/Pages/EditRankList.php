<?php

namespace App\Filament\Resources\RankListResource\Pages;

use App\Filament\Resources\RankListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRankList extends EditRecord
{
    protected static string $resource = RankListResource::class;

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
