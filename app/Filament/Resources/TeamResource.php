<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContestResource\RelationManagers\TeamsRelationManager;
use App\Filament\Resources\TeamResource\Pages;
use App\Models\Team;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Unique;

class TeamResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $model = Team::class;

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Team name')
                                    ->unique(ignoreRecord: true, modifyRuleUsing: function (Unique $rule, $get) {

                                        return $rule->where('contest_id', $get('contest_id') ?? $get('owner_id'));
                                    }),
                                Forms\Components\Select::make('contest_id')
                                    ->relationship('contest', 'name')
                                    ->hiddenOn(TeamsRelationManager::class)
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Select::make('contest_type')
                                            ->required(),
                                    ])
                                    ->native(false),
                            ]),

                        Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('rank')
                                    ->numeric()
                                    ->minValue(1)
                                    ->placeholder('Team ranking')
                                    ->helperText('Final position in the contest'),

                                Forms\Components\TextInput::make('solveCount')
                                    ->label('Solve Count')
                                    ->numeric()
                                    ->minValue(0)
                                    ->placeholder('Number of problems solved'),
                            ]),
                    ]),

                Section::make('Team Members')
                    ->schema([
                        Forms\Components\Select::make('members')
                            ->relationship('members', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->createOptionForm(UserResource::form($form)->getComponents())
                            ->native(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('contest.name')
                    ->sortable()
                    ->hiddenOn(TeamsRelationManager::class)
                    ->searchable(),

                Tables\Columns\TextColumn::make('contest.contest_type')
                    ->badge()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('rank')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn (Team $record): string => match (true) {
                        $record->rank === 1 => 'warning',
                        $record->rank === 2 => 'gray',
                        $record->rank === 3 => 'amber',
                        default => 'primary'
                    }),

                Tables\Columns\TextColumn::make('solveCount')
                    ->label('Problems Solved')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('members_count')
                    ->label('Members')
                    ->counts('members')
                    ->sortable(),

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
                Tables\Filters\SelectFilter::make('contest_id')
                    ->label('Contest')
                    ->relationship('contest', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),

            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),

                Tables\Actions\Action::make('view_contest')
                    ->icon('heroicon-o-trophy')
                    ->iconButton()
                    ->url(fn (Team $record): string => ContestResource::getUrl('edit', ['record' => $record->contest_id])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('updateRanks')
                        ->label('Update Ranks')
                        ->icon('heroicon-o-arrow-path')
                        ->action(function (array $records) {
                            // Implement bulk rank update logic
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'contest.name'];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
