<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RankListResource\Pages;
use App\Filament\Resources\TrackerResource\RelationManagers\RankListsRelationManager;
use App\Models\RankList;
use App\Models\Tracker;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Unique;

class RankListResource extends Resource
{
    protected static ?string $model = RankList::class;

    protected static ?string $slug = 'rank-lists';

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationLabel = 'Ranking Lists';

    protected static ?string $navigationGroup = 'Management';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'keyword';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        Select::make('tracker_id')
                            ->relationship('tracker', 'title')
                            ->hiddenOn(RankListsRelationManager::class)
                            ->searchable()
                            ->preload()
                            ->required()
                        ,

                        TextInput::make('keyword')
                            ->required()
                            ->maxLength(255)
                            ->unique(
                                ignoreRecord: true,
                                modifyRuleUsing: fn(Unique $rule, callable $get) => $rule->where('tracker_id', $get('tracker_id'))
                            )
                            ->placeholder('Enter ranking keyword')
                            ->helperText('Must be unique within the tracker'),
                    ])
                    ->columns(2),

                Section::make('Details')
                    ->schema([
                        Textarea::make('description')
                            ->maxLength(65535)
                            ->placeholder('Enter description or instructions')
                            ->columnSpanFull(),

                        Grid::make()
                            ->schema([
                                TextInput::make('weight_of_upsolve')
                                    ->required()
                                    ->numeric()
                                    ->step(0.01)
                                    ->default(1.0)
                                    ->minValue(0)
                                    ->suffixIcon('heroicon-m-scale')
                                    ->helperText('Weighting factor for upsolve points'),

                                TextInput::make('order')
                                    ->required()
                                    ->integer()
                                    ->helperText('Display order within tracker'),

                                Checkbox::make('is_archived')
                                    ->label('Archived')
                                    ->default(false)
                                    ->helperText('Hide from active listings'),
                            ])
                            ->columns(3),
                    ]),

                Section::make('Metadata')
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Created Date')
                            ->content(fn(?RankList $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                        Placeholder::make('updated_at')
                            ->label('Last Modified Date')
                            ->content(fn(?RankList $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tracker.title')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->hiddenOn(RankListsRelationManager::class)
                    ->description(fn(RankList $record): string => $record->tracker?->status ? $record->tracker->status->name : ''),

                TextColumn::make('keyword')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('description')
                    ->limit(50)
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('weight_of_upsolve')
                    ->numeric(2)
                    ->sortable(),

                TextColumn::make('order')
                    ->sortable()
                    ->alignCenter(),

                CheckboxColumn::make('is_archived')
                    ->label('Archived')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('tracker')
                    ->relationship('tracker', 'title')
                    ->searchable()
                    ->preload(),

                TernaryFilter::make('is_archived')
                    ->label('Archive Status')
                    ->placeholder('All lists')
                    ->trueLabel('Archived only')
                    ->falseLabel('Active only'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order')
            ->searchable()
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRankLists::route('/'),
            'create' => Pages\CreateRankList::route('/create'),
            'edit' => Pages\EditRankList::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['tracker']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['keyword', 'description', 'tracker.title'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->tracker) {
            $details['Tracker'] = $record->tracker->title;
        }

        $details['Weight'] = $record->weight_of_upsolve;
        $details['Archived'] = $record->is_archived ? 'Yes' : 'No';

        return $details;
    }
}
