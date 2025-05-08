<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserSolveStatOnEventResource\Pages;
use App\Models\UserSolveStatOnEvent;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserSolveStatOnEventResource extends Resource
{
    protected static ?string $model = UserSolveStatOnEvent::class;

    protected static ?string $slug = 'user-solve-stat-on-events';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                Select::make('event_id')
                    ->relationship('event', 'title')
                    ->searchable()
                    ->required(),

                TextInput::make('solve_count')
                    ->required()
                    ->integer(),

                TextInput::make('upsolve_count')
                    ->required()
                    ->integer(),

                Checkbox::make('participation'),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?UserSolveStatOnEvent $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?UserSolveStatOnEvent $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('event.title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('solve_count'),

                TextColumn::make('upsolve_count'),

                TextColumn::make('participation'),
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
            'index' => Pages\ListUserSolveStatOnEvents::route('/'),
            'create' => Pages\CreateUserSolveStatOnEvent::route('/create'),
            'edit' => Pages\EditUserSolveStatOnEvent::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['user', 'event']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['user.name', 'event.title'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->user) {
            $details['User'] = $record->user->name;
        }

        if ($record->event) {
            $details['Event'] = $record->event->title;
        }

        return $details;
    }
}
