<?php

namespace App\Filament\Resources;

use App\Enums\ContestType;
use App\Enums\Visibility;
use App\Filament\Resources\ContestResource\Pages;
use App\Filament\Resources\ContestResource\RelationManagers\TeamsRelationManager;
use App\Models\Contest;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ContestResource extends Resource
{
    protected static ?string $model = Contest::class;
    protected static ?string $slug = 'contests';
    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationLabel = 'Contests';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Contest Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')

                                    ->required()
                                    ->maxLength(255),

                                Select::make('gallery_id')
                                    ->relationship('gallery', 'title', modifyQueryUsing: function (Builder $query) {
                                        $query->where('status', Visibility::PUBLISHED);
                                    })
                                    ->preload()
                                    ->searchable(),

                                ToggleButtons::make('contest_type')
                                    ->options(ContestType::class)
                                    ->inline()
                                    ->required(),

                                TextInput::make('location')
                                    ->maxLength(50),

                                DatePicker::make('date')
                                    ->native(false),
                            ]),

                        Grid::make(1)
                            ->schema([
                                TextInput::make('description')
                                    ->maxLength(255),

                                TextInput::make('standings_url')
                                    ->url()
                                    ->prefix('https://')
                                    ->maxLength(255),
                            ]),
                    ]),

                Section::make('Metadata')
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Created Date')
                            ->content(fn(?Contest $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                        Placeholder::make('updated_at')
                            ->label('Last Modified Date')
                            ->content(fn(?Contest $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                    ])
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('contest_type')
                    ->colors([
                        'primary' => fn($state) => true,
                    ])
                    ->badge()
                    ->sortable(),

                TextColumn::make('gallery.title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('location')
                    ->searchable(),

                TextColumn::make('date')
                    ->date()
                    ->sortable(),

                TextColumn::make('teams_count')
                    ->counts('teams')
                    ->label('Teams'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('contest_type')
                    ->options(ContestType::class),
                SelectFilter::make('gallery')
                    ->relationship('gallery', 'title'),
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
            'index' => Pages\ListContests::route('/'),
            'create' => Pages\CreateContest::route('/create'),
            'edit' => Pages\EditContest::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            TeamsRelationManager::class,
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['gallery']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'gallery.title', 'location'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->gallery) {
            $details['Gallery'] = $record->gallery->title;
        }

        if ($record->location) {
            $details['Location'] = $record->location;
        }

        return $details;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
