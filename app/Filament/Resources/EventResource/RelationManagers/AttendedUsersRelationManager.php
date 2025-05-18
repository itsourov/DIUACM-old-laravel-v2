<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Filament\Resources\UserResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendedUsersRelationManager extends RelationManager
{
    protected static string $relationship = 'attendedUsers';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                ...UserResource::form($form)->getComponents()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ...UserResource::table($table)->getColumns()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->recordSelectSearchColumns(['email', 'name', 'student_id', 'username', 'phone', 'codeforces_handle', 'atcoder_handle', 'vjudge_handle'])
                    ->preloadRecordSelect()
                    ->modalWidth('3xl')
                    ->recordTitle(function ($record) {
                        return $record->name . ' || ' . $record->username;
                    })
                    ->multiple(),
            ])
            ->inverseRelationship('attendedEvents')
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
