<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Filament\Resources\RankListResource;
use App\Models\RankList;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RankListsRelationManager extends RelationManager
{
    protected static string $relationship = 'rankLists';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Connection Information')
                    ->schema([
                        Forms\Components\TextInput::make('weight')
                            ->helperText('The weight of the event in this rank list.')
                            ->numeric()
                            ->default(1.0)
                            ->step(0.01)
                            ->minValue(0.0)
                            ->maxValue(1.0)
                            ->required(),
                    ]),
                ...RankListResource::form($form)->getComponents(),
            ]);
    }

    public function table(Table $table): Table
    {

        return $table
            ->recordTitleAttribute('keyword')
            ->recordTitle(function ($record) {
                return $record->keyword . ' || ' . $record->tracker->title;
            })
            ->columns([
                Tables\Columns\TextColumn::make('weight')
                    ->badge()
                    ->tooltip('The weight of this event to this ranklist')
                    ->sortable(),
                ...RankListResource::table($table)->getColumns(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make('attach')
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['title'])
                    ->modalWidth('3xl')
                    ->recordTitle(function ($record) {
                        return $record->keyword . ' || ' . $record->tracker->title;
                    })
                    ->multiple()
                    ->form(fn(AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\TextInput::make('weight')
                            ->numeric()
                            ->default(1.0)
                            ->step(0.01)
                            ->minValue(0.0)
                            ->maxValue(1.0)
                            ->required(),


                    ])
                ,])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
