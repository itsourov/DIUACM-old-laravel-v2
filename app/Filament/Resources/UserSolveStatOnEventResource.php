<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserSolveStatOnEventResource\Pages;
use App\Filament\Resources\UserSolveStatOnEventResource\RelationManagers;
use App\Models\UserSolveStatOnEvent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserSolveStatOnEventResource extends Resource
{
    protected static ?string $model = UserSolveStatOnEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'title')
                    ->required(),
                Forms\Components\TextInput::make('solve_count')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('upsolve_count')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('participation')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('solve_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('upsolve_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('participation')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserSolveStatOnEvents::route('/'),
            'create' => Pages\CreateUserSolveStatOnEvent::route('/create'),
            'edit' => Pages\EditUserSolveStatOnEvent::route('/{record}/edit'),
        ];
    }
}
