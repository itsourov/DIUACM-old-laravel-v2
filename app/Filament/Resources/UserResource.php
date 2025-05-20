<?php

namespace App\Filament\Resources;

use App\Enums\Gender;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Users';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->columns()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        SpatieMediaLibraryFileUpload::make('Profile Image')
                            ->collection('profile-images')
                            ->disk('profile-images')
                            ->image()
                            ->avatar()
                            ->previewable()
                            ->imageEditor()
                            ->maxSize(1024 * 5),

                        Forms\Components\TextInput::make('username')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\Select::make('gender')
                            ->options(Gender::class)
                            ->enum(Gender::class),

                    ]),

                Forms\Components\Section::make('Academic Information')
                    ->columns()
                    ->schema([
                        Forms\Components\TextInput::make('student_id')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('department')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('starting_semester')
                            ->maxLength(255),
                    ]),

                Forms\Components\Section::make('Competitive Programming Profiles')
                    ->columns()
                    ->schema([
                        Forms\Components\TextInput::make('codeforces_handle')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('max_cf_rating')
                            ->numeric()
                            ->label('Max CF Rating'),
                        Forms\Components\TextInput::make('atcoder_handle')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('vjudge_handle')
                            ->maxLength(255),
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
                SpatieMediaLibraryImageColumn::make('profile Image')
                    ->collection('profile-images')
                    ->disk('profile-images'),
                Tables\Columns\TextColumn::make('username')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Email Verified')
                    ->toggleable()->toggledHiddenByDefault()
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('student_id')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('department')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('codeforces_handle')
                    ->searchable()
                    ->url(fn($record) => $record->codeforces_handle ? "https://codeforces.com/profile/$record->codeforces_handle" : null)
                    ->openUrlInNewTab()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('max_cf_rating')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('gender')
                    ->options(Gender::class),
                Tables\Filters\SelectFilter::make('department')
                    ->options(fn() => User::distinct()->pluck('department', 'department')->filter()->toArray()),
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email verification')
                    ->placeholder('All users')
                    ->trueLabel('Verified only')
                    ->falseLabel('Unverified only'),
                Tables\Filters\Filter::make('has_cf_handle')
                    ->label('Has Codeforces handle')
                    ->toggle()
                    ->query(fn(Builder $query) => $query->whereNotNull('codeforces_handle')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\Action::make('verify_email')
                    ->icon('heroicon-o-envelope')
                    ->iconButton()
                    ->hidden(fn($record) => !is_null($record->email_verified_at))
                    ->action(fn($record) => $record->update(['email_verified_at' => now()])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'username', 'student_id', 'codeforces_handle'];
    }
}
