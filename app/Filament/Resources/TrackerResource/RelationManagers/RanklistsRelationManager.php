<?php

namespace App\Filament\Resources\TrackerResource\RelationManagers;

use App\Filament\Resources\RankListResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RanklistsRelationManager extends RelationManager
{
    protected static string $relationship = 'ranklists';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                ...RankListResource::form($form)->getComponents(),
                Forms\Components\Hidden::make('owner_id')
                    ->default($this->ownerRecord->id),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('keyword')
            ->columns(RankListResource::table($table)->getColumns())
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->url(route('filament.admin.resources.rank-lists.edit', $this->ownerRecord->id)),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
