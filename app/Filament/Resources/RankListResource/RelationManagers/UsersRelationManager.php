<?php

namespace App\Filament\Resources\RankListResource\RelationManagers;

use App\Filament\Resources\UserResource;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Connection Information')
                    ->schema([
                        Forms\Components\TextInput::make('score')
                            ->helperText('The score of this user in this rank list.')
                            ->numeric()
                            ->default(0)
                            ->step(0.01)
                            ->minValue(0.0)
                            ->required(),
                    ]),
                ...UserResource::form($form)->getComponents(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('username', 'desc')

            ->columns([
                Tables\Columns\TextColumn::make('score')
                    ->badge()
                    ->tooltip('The score of this user in this rank list')
                    ->sortable(),
                ...UserResource::table($table)->getColumns(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\TextInput::make('score')
                            ->numeric()
                            ->default(0)
                            ->step(0.01)
                            ->minValue(0.0)
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
