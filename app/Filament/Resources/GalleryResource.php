<?php

namespace App\Filament\Resources;

use App\Enums\Visibility;
use App\Filament\Resources\GalleryResource\Pages;
use App\Filament\Resources\MediaRelationManagerResource\RelationManagers\MediaRelationManager;
use App\Models\Gallery;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
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
use Illuminate\Support\Str;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $slug = 'galleries';

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Gallery Information')
                    ->columns(2)
                    ->schema([

                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, callable $set) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Gallery::class, 'slug', fn ($record) => $record),

                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),

                        ToggleButtons::make('status')
                            ->options(Visibility::class)
                            ->inline()
                            ->default(Visibility::DRAFT)
                            ->required(),

                        TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->required(),

                    ]),

                Section::make('Images')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('images')
                            ->image()
                            ->multiple()
                            ->collection('gallery-images')
                            ->disk('gallery-images')
                            ->responsiveImages()
                            ->reorderable()
                            ->imageEditor()
                            ->previewable()
                            ->downloadable()
                            ->maxFiles(50)
                            ->helperText('Upload up to 50 images. Images will be optimized automatically.')
                            ->columnSpanFull(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('order')
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->limit(30)
                    ->toggleable()->toggledHiddenByDefault(),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('order')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(Visibility::class),
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

    public static function getRelations(): array
    {
        return [
            MediaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'slug', 'description'];
    }
}
