<?php

namespace App\Filament\Resources;

use App\Enums\ContestType;
use App\Filament\Resources\ContestResource\Pages;
use App\Filament\Resources\ContestResource\RelationManagers;
use App\Filament\Resources\ContestResource\RelationManagers\TeamsRelationManager;
use App\Models\Contest;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContestResource extends Resource
{
    protected static ?string $model = Contest::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?int $navigationSort = 10;
    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadgeColor(): string
    {
        return 'success';
    }

    public static function getNavigationBadge(): ?string
    {
        return Contest::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Basic Information')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->autocapitalize()
                                    ->placeholder('Enter contest name'),

                                Forms\Components\Select::make('contest_type')
                                    ->required()
                                    ->enum(ContestType::class)
                                    ->options(ContestType::class)
                                    ->native(false)
                                    ->searchable(),

                                Forms\Components\Select::make('gallery_id')
                                    ->relationship('gallery', 'title')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->native(false),
                            ]),

                        Section::make('Location & Schedule')
                            ->schema([
                                Forms\Components\TextInput::make('location')
                                    ->maxLength(255)
                                    ->placeholder('Contest location'),

                                Forms\Components\DateTimePicker::make('date')
                                    ->native(false)
                                    ->displayFormat('F j, Y \a\t g:i A'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Additional Details')
                            ->schema([
                                Forms\Components\TextInput::make('standings_url')
                                    ->url()
                                    ->maxLength(255)
                                    ->placeholder('https://example.com/standings')
                                    ->helperText('Link to external standings page if available'),

                                Forms\Components\Textarea::make('description')
                                    ->rows(6)
                                    ->placeholder('Contest description and details'),
                            ]),

                        Section::make('Statistics')
                            ->schema([
                                Forms\Components\Placeholder::make('teams_count')
                                    ->label('Total Teams')
                                    ->content(fn(Contest $record): int => $record->teams()->count())
                                    ->visibleOn('edit'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn(Contest $record): string => $record->location ?? '')
                    ->wrap(),

                Tables\Columns\TextColumn::make('contest_type')
                    ->badge()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('date')
                    ->dateTime('M j, Y \a\t g:i A')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('gallery.title')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('teams_count')
                    ->label('Teams')
                    ->counts('teams')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Location')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                SelectFilter::make('contest_type')
                    ->options(ContestType::class)
                    ->multiple(),

                Tables\Filters\Filter::make('has_gallery')
                    ->label('With Gallery')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('gallery_id')),

                Tables\Filters\Filter::make('upcoming')
                    ->query(fn(Builder $query): Builder => $query->where('date', '>=', now())),

                Tables\Filters\Filter::make('past')
                    ->query(fn(Builder $query): Builder => $query->where('date', '<', now())),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),

//                Action::make('view_teams')
//                    ->label('Teams')
//                    ->icon('heroicon-o-user-group')
//                    ->iconButton()
//                    ->url(fn(Contest $record): string => TeamResource::getUrl('index', ['contest_id' => $record->id])),

                Action::make('standings')
                    ->icon('heroicon-o-trophy')
                    ->iconButton()
                    ->url(fn(Contest $record): ?string => $record->standings_url)
                    ->openUrlInNewTab()
                    ->hidden(fn(Contest $record): bool => empty($record->standings_url)),
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
            TeamsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContests::route('/'),
            'create' => Pages\CreateContest::route('/create'),
            'edit' => Pages\EditContest::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'location', 'description'];
    }
}
