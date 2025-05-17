<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RankListResource\Pages;
use App\Filament\Resources\TrackerResource\RelationManagers\RanklistsRelationManager;
use App\Models\RankList;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Unique;

class RankListResource extends Resource
{
    protected static ?string $model = RankList::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 21;
    protected static ?string $recordTitleAttribute = 'keyword';
    protected static bool $shouldRegisterNavigation = false;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('tracker_id')
                            ->hiddenOn(RanklistsRelationManager::class)
                            ->relationship('tracker', 'title')
                            ->required(),
                        Forms\Components\TextInput::make('keyword')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true, modifyRuleUsing: function (Unique $rule, $get) use ($form) {
                                return $rule->where('tracker_id', $get('tracker_id') ?? $get('owner_id'));
                            }),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('weight_of_upsolve')
                            ->default(0.25)
                            ->step(0.01)
                            ->numeric()
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('order')
                            ->default(0)
                            ->required()
                            ->numeric(),
                        Forms\Components\Toggle::make('is_active')
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tracker.title')
                    ->hiddenOn(RanklistsRelationManager::class)
                    ->sortable(),
                Tables\Columns\TextColumn::make('keyword')
                    ->searchable(),
                Tables\Columns\TextColumn::make('weight_of_upsolve')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
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
            'index' => Pages\ListRankLists::route('/'),
            'create' => Pages\CreateRankList::route('/create'),
            'edit' => Pages\EditRankList::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['keyword', 'description', 'tracker.title'];
    }
}
