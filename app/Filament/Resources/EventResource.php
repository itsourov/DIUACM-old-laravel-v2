<?php

namespace App\Filament\Resources;

use App\Enums\EventType;
use App\Enums\ParticipationScope;
use App\Enums\Visibility;
use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers\AttendedUsersRelationManager;
use App\Filament\Resources\EventResource\RelationManagers\RankListsRelationManager;
use App\Models\Event;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->columnSpan('full'),

                        RichEditor::make('description')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'blockquote',
                                'codeBlock',
                            ])
                            ->placeholder('Enter event description')
                            ->columnSpan('full'),

                        Grid::make()
                            ->schema([
                                ToggleButtons::make('type')
                                    ->enum(EventType::class)
                                    ->options(EventType::class)
                                    ->default(EventType::CONTEST)
                                    ->inline()
                                    ->required(),

                                ToggleButtons::make('status')
                                    ->enum(Visibility::class)
                                    ->options(Visibility::class)
                                    ->default(Visibility::DRAFT)
                                    ->inline()
                                    ->required(),
                            ]),
                    ]),

                Section::make('Event Schedule')
                    ->schema([
                        Grid::make()
                            ->schema([
                                DateTimePicker::make('starting_at')
                                    ->seconds(false)
                                    ->timezone('Asia/Dhaka')
                                    ->label('Starting Date')
                                    ->required(),

                                DateTimePicker::make('ending_at')
                                    ->seconds(false)
                                    ->label('Ending Date')
                                    ->timezone('Asia/Dhaka')
                                    ->after('starting_at')
                                    ->required(),
                                Placeholder::make('duration')
                                    ->live()
                                    ->content(fn ($get) => calculateRuntime($get('starting_at'), $get('ending_at')))
                                    ->columnSpan('full'),
                            ]),
                    ]),

                Section::make('Event Access')
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('event_link')
                                    ->unique(ignoreRecord: true)
                                    ->url()
                                    ->columnSpan(1),

                                TextInput::make('event_password')
                                    ->string()
                                    ->columnSpan(1),
                            ]),

                        Grid::make()
                            ->schema([
                                ToggleButtons::make('participation_scope')
                                    ->columnSpanFull()
                                    ->enum(ParticipationScope::class)
                                    ->options(ParticipationScope::class)
                                    ->default(ParticipationScope::OPEN_FOR_ALL)
                                    ->inline()
                                    ->required(),

                                Checkbox::make('open_for_attendance')
                                    ->label('Open for Attendance')
                                    ->helperText('Check this if the event is ready for attendees'),

                                Checkbox::make('strict_attendance')
                                    ->label('Strict Attendance')
                                    ->helperText('If enabled then the users who didn\'t gave attendance their solve count wont be counted.'),
                            ]),
                    ]),

                Section::make('Event History')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Placeholder::make('created_at')
                                    ->label('Created Date')
                                    ->content(fn (?Event $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                                Placeholder::make('updated_at')
                                    ->label('Last Modified Date')
                                    ->content(fn (?Event $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                            ]),
                    ])->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('starting_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('description')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('status'),

                TextColumn::make('starting_at')
                    ->sortable(true)
                    ->timezone('Asia/Dhaka')
                    ->dateTime('M d, Y - h:i A')
                    ->label('Starting Date'),

                TextColumn::make('ending_at')
                    ->label('Ending Date')
                    ->toggleable()->toggledHiddenByDefault()
                    ->date(),

                TextColumn::make('event_link')
                    ->searchable()
                    ->toggleable()->toggledHiddenByDefault(),
                ToggleColumn::make('open_for_attendance')
                    ->sortable(),
                ToggleColumn::make('strict_attendance')
                    ->sortable(),

                TextColumn::make('type'),

                Tables\Columns\TextColumn::make('participation_scope'),
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
            RankListsRelationManager::class,
            AttendedUsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}

function calculateRuntime($start, $end): ?string
{
    if (! $start || ! $end) {
        return 'N/A'; // Placeholder text when either time is not set
    }

    $start = Carbon::parse($start);
    $end = Carbon::parse($end);

    $diff = $start->diff($end);

    try {
        return $diff->forHumans();
    } catch (Exception $e) {
        return 'Calculation error: '.$e->getMessage();
    }
}
