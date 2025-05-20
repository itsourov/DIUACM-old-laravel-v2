<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserSolveStatOnEventResource\Pages;
use App\Models\UserSolveStatOnEvent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserSolveStatOnEventResource extends Resource
{
    protected static ?string $model = UserSolveStatOnEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'User Solve Stats';

    protected static ?int $navigationSort = 30;

    protected static ?string $recordTitleAttribute = 'id';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User & Event Information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('event_id')
                            ->relationship('event', 'title')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),

                Forms\Components\Section::make('Performance Statistics')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('solve_count')
                            ->label('Solved Problems')
                            ->helperText('Number of problems solved during the event')
                            ->required()
                            ->numeric()
                            ->minValue(0),
                        Forms\Components\TextInput::make('upsolve_count')
                            ->label('Upsolved Problems')
                            ->helperText('Number of problems solved after the event ended')
                            ->required()
                            ->numeric()
                            ->minValue(0),
                        Forms\Components\Toggle::make('participation')
                            ->label('Participated')
                            ->helperText('Whether user officially participated in the event')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('user.codeforces_handle')
                    ->label('CF Handle')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->user->codeforces_handle ?
                        "https://codeforces.com/profile/{$record->user->codeforces_handle}" : null)
                    ->openUrlInNewTab()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('event.title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('solve_count')
                    ->label('Solved')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('upsolve_count')
                    ->label('Upsolved')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\IconColumn::make('participation')
                    ->boolean()
                    ->label('Participated')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('event_id')
                    ->relationship('event', 'title')
                    ->searchable()
                    ->preload()
                    ->label('Event'),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('view_event')
                    ->icon('heroicon-o-calendar')
                    ->iconButton()
                    ->url(fn (UserSolveStatOnEvent $record): string => EventResource::getUrl('edit', ['record' => $record->event_id])),
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

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
