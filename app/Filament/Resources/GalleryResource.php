<?php

namespace App\Filament\Resources;

use App\Enums\Visibility;
use App\Filament\Resources\GalleryResource\Pages;
use App\Filament\Resources\GalleryyResource\RelationManagers\MediaRelationManager;
use App\Models\Gallery;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $slug = 'galleries';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required(),

                TextInput::make('slug')
                    ->required()
                    ->unique(Gallery::class, 'slug', fn($record) => $record),

                TextInput::make('description'),

                ToggleButtons::make('status')
                    ->options(Visibility::class)
                    ->inline()
                    ->default(Visibility::DRAFT)
                    ->required(),

                TextInput::make('order')
                    ->required()
                    ->integer(),

                SpatieMediaLibraryFileUpload::make('images')
                    ->image()
                    ->multiple()
                    ->collection('gallery')
                    ->reorderable()
                    ->imageEditor()
                    ->previewable()
                    ->columnSpanFull()
                    ->required(),


                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?Gallery $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?Gallery $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
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

                TextColumn::make('description'),

                TextColumn::make('status'),

                TextColumn::make('order'),
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
        return ['title', 'slug'];
    }
}
