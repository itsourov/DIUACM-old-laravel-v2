<?php

namespace App\Filament\Resources;

use App\Enums\Visibility;
use App\Filament\Resources\TrackerResource\Pages;
use App\Filament\Resources\TrackerResource\RelationManagers\RankListsRelationManager;
use App\Models\Tracker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class TrackerResource extends Resource
{
    protected static ?string $model = Tracker::class;

    protected static ?string $slug = 'trackers';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Performance Trackers';

    protected static ?string $navigationGroup = 'Management';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter tracker title')
                            ->helperText('A descriptive title for this tracker'),

                        TextInput::make('slug')
                            ->required()
                            ->unique(Tracker::class, 'slug', fn($record) => $record)
                            ->helperText('Used in URLs'),

                        ToggleButtons::make('status')
                            ->options(Visibility::class)
                            ->enum(Visibility::class)
                            ->inline()
                            ->required()
                            ->default(Visibility::DRAFT)
                            ->helperText('Set visibility status for this tracker'),

                        TextInput::make('order')
                            ->required()
                            ->integer()
                            ->default(fn() => Tracker::max('order') + 1)
                            ->helperText('Lower numbers appear first in lists'),
                    ])
                    ->columns(2),

                Section::make('Description')
                    ->schema([
                        Textarea::make('description')
                            ->maxLength(65535)
                            ->placeholder('Enter detailed description of this tracker')
                            ->helperText('You can provide markdown formatting')
                            ->columnSpanFull(),
                    ]),

                Section::make('Metadata')
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Created Date')
                            ->content(fn(?Tracker $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                        Placeholder::make('updated_at')
                            ->label('Last Modified Date')
                            ->content(fn(?Tracker $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->wrap(),

                TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make('description')
                    ->limit(50)
                    ->html()
                    ->searchable()
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(fn(Visibility $state): string => match ($state) {
                        Visibility::PUBLISHED => 'success',
                        Visibility::DRAFT => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('order')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(Visibility::class)
                    ->label('Status'),

                TernaryFilter::make('has_description')
                    ->label('Has Description')
                    ->placeholder('All trackers')
                    ->trueLabel('With description')
                    ->falseLabel('Without description')
                    ->queries(
                        true: fn(Builder $query) => $query->whereNotNull('description')->where('description', '!=', ''),
                        false: fn(Builder $query) => $query->whereNull('description')->orWhere('description', ''),
                    ),
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
            'index' => Pages\ListTrackers::route('/'),
            'create' => Pages\CreateTracker::route('/create'),
            'edit' => Pages\EditTracker::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            RankListsRelationManager::class
        ];
    }
    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'slug', 'description'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Status' => $record->status->name,
            'Order' => $record->order,
        ];
    }
}
