<?php

namespace App\Filament\Resources\RankListResource\RelationManagers;

use App\Filament\Resources\EventResource;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventsRelationManager extends RelationManager
{
    protected static string $relationship = 'events';

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
                ...EventResource::form($form)->getComponents(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->recordTitle(function (Event $record) {
                return $record->title . '(' . $record->event_link . ')';
            })
            ->columns([
                Tables\Columns\TextColumn::make('weight')
                    ->badge()
                    ->tooltip('The weight of this event to this ranklist')
                    ->sortable(),
                ...EventResource::table($table)->getColumns(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make('attach')
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['title'])
                    ->modalWidth('3xl')
                    ->recordTitle(function (Event $record) {
                        return $record->title . ' || ' . $record->starting_at;
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

                    ]),
            ])
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
