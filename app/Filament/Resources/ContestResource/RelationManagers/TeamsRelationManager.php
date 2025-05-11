<?php

namespace App\Filament\Resources\ContestResource\RelationManagers;

use App\Filament\Resources\TeamResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamsRelationManager extends RelationManager
{
    protected static string $relationship = 'teams';

    public function form(Form $form): Form
    {


        return $form
            ->schema([
                ...TeamResource::form($form)->getComponents(),
                Forms\Components\Hidden::make('owner_id')
                    ->default($this->ownerRecord->id),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns(TeamResource::table($table)->getColumns())
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
