<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContestResource\RelationManagers\TeamsRelationManager;
use App\Filament\Resources\TeamResource\Pages;

use App\Models\Team;
use App\Models\User;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;
    protected static ?string $slug = 'teams';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationLabel = 'Teams';
    protected static ?int $navigationSort = 2;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Team Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                Select::make('contest_id')
                                    ->relationship('contest', 'name')
                                    ->hiddenOn(TeamsRelationManager::class)
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('rank')
                                    ->integer()
                                    ->minValue(1)
                                    ->label('Team Rank')
                                    ->helperText('Position in the contest ranking'),

                                TextInput::make('solveCount')
                                    ->integer()
                                    ->minValue(0)
                                    ->label('Problems Solved')
                                    ->helperText('Number of problems solved during the contest'),
                            ]),
                        Select::make('members')
                            ->relationship('members', 'name')
                            ->getOptionLabelFromRecordUsing(fn(User $record) => "{$record->name} ({$record->student_id})")
                            ->searchable(['name', 'email', 'student_id', 'username', 'codeforces_handle'])
                            ->preload()
                            ->multiple(),
                    ]),

                Section::make('Metadata')
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Created Date')
                            ->content(fn(?Team $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                        Placeholder::make('updated_at')
                            ->label('Last Modified Date')
                            ->content(fn(?Team $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
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

                TextColumn::make('contest.name')
                    ->hiddenOn(TeamsRelationManager::class)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('rank')
                    ->sortable(),

                TextColumn::make('solveCount')
                    ->sortable()
                    ->label('Problems Solved'),

                TextColumn::make('members_count')
                    ->counts('members')
                    ->label('Team Size'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('contest')
                    ->relationship('contest', 'name')
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }


    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'contest.name'];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
