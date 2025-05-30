<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\EventResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendedEventsRelationManager extends RelationManager
{
    protected static string $relationship = 'attendedEvents';
    protected static ?string $inverseRelationship = 'attendedUsers';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                ...EventResource::form($form)->getComponents(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->defaultSort('starting_at', 'desc')

            ->columns([
                Tables\Columns\TextColumn::make('title'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->recordSelectSearchColumns(['title', 'description'])
                    ->preloadRecordSelect()
                    ->modalWidth('3xl')
                    ->recordTitle(function ($record) {
                        return $record->title . ' || ' . $record->starting_at->format('Y-m-d H:i');
                    })
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
