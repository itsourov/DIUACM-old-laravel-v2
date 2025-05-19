<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Enums\Visibility;
use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $slug = 'blog-posts';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';


    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Post Content')
                    ->schema([
                        TextInput::make('title')
                            ->columnSpanFull()
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(string $state, Set $set) => $set('slug', Str::slug($state))
                            ),

                        TextInput::make('slug')
                            ->rules(['required', 'regex:/^[a-zA-Z0-9-]+$/'])
                            ->helperText('Cannot contain spaces or special characters.')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('author')
                            ->required()
                            ->maxLength(255),

                        SpatieMediaLibraryFileUpload::make('Featured Image')

                            ->collection('post-featured-images')
                            ->disk('post-featured-images')
                            ->helperText('This cover image is used in your blog post as a feature image. Recommended image size 1200 X 628')
                            ->image()
                            ->responsiveImages()
                            ->previewable()
                            ->preserveFilenames()
                            ->imageEditor()
                            ->maxSize(1024 * 5),

                        TinyEditor::make('content')
                            ->fileAttachmentsDisk('blog-images')
                            ->fileAttachmentsVisibility('public')
                            ->profile('full')
                            ->showMenuBar()
                            ->columnSpanFull()
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Publication Settings')
                    ->schema([
                        Select::make('status')
                            ->options(Visibility::class)
                            ->required()
                            ->native(false),

                        DateTimePicker::make('published_at')
                            ->timezone('Asia/Dhaka')
                            ->label('Publication Date')
                            ->nullable()
                            ->helperText('Leave empty to use current date when publishing'),

                        Checkbox::make('is_featured')
                            ->label('Feature this post')
                            ->helperText('Featured posts appear prominently on the website'),

                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->wrap(),

                TextColumn::make('author')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime()
                    ->sortable(),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(Visibility::class),

                TernaryFilter::make('is_featured')
                    ->label('Featured posts only'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'slug', 'author', 'content'];
    }
}
