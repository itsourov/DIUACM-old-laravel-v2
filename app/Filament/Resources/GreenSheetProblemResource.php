<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GreenSheetProblemResource\Pages;
use App\Models\GreenSheetProblem;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GreenSheetProblemResource extends Resource
{
    protected static ?string $model = GreenSheetProblem::class;

    protected static ?string $slug = 'green-sheet-problems';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required(),

                TextInput::make('order')
                    ->required()
                    ->integer(),

                TextInput::make('oj'),

                TextInput::make('oj_id'),

                TextInput::make('oj_link')
                    ->required(),

                TextInput::make('editorial'),

                TextInput::make('hint'),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?GreenSheetProblem $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?GreenSheetProblem $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('order'),

                TextColumn::make('oj'),

                TextColumn::make('oj_id'),

                TextColumn::make('oj_link'),

                TextColumn::make('editorial'),

                TextColumn::make('hint'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGreenSheetProblems::route('/'),
            'create' => Pages\CreateGreenSheetProblem::route('/create'),
            'edit' => Pages\EditGreenSheetProblem::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title'];
    }
}
