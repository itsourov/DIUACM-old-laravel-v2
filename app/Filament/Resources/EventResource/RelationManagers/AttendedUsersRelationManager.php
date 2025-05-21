<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Filament\Resources\UserResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;

class AttendedUsersRelationManager extends RelationManager
{
    protected static string $relationship = 'attendedUsers';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                ...UserResource::form($form)->getComponents(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                SpatieMediaLibraryImageColumn::make('profile Image')
                    ->collection('avatar')
                    ->disk('avatar'),
                Tables\Columns\TextColumn::make('username')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Email Verified')
                    ->toggleable()->toggledHiddenByDefault()
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('student_id')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('department')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('codeforces_handle')
                    ->searchable()
                    ->url(fn ($record) => $record->codeforces_handle ? "https://codeforces.com/profile/$record->codeforces_handle" : null)
                    ->openUrlInNewTab()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('max_cf_rating')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

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
                        return $record->name.' || '.$record->username;
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
