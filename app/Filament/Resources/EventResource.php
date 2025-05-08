<?php

namespace App\Filament\Resources;

use App\Enums\EventType;
use App\Enums\ParticipationScope;
use App\Enums\Visibility;
use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Carbon\Carbon;
use Exception;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
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
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;
    protected static ?string $slug = 'events';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationLabel = 'Events';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->description('Enter the primary details about this event')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Event title')
                            ->autofocus()
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
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('event-images')
                            ->placeholder('Enter event description')
                            ->columnSpan('full'),

                        Grid::make(2)
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
                                    ->helperText('Only published events are visible to users')
                                    ->inline()
                                    ->required(),
                            ]),
                    ]),

                Section::make('Event Schedule')
                    ->description('Set the timing for this event')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                DateTimePicker::make('starting_at')
                                    ->seconds(false)
                                    ->timezone('Asia/Dhaka')
                                    ->label('Starting Date')
                                    ->required()
                                    ->native(false)
                                    ->displayFormat('M d, Y - h:i A'),

                                DateTimePicker::make('ending_at')
                                    ->seconds(false)
                                    ->label('Ending Date')
                                    ->timezone('Asia/Dhaka')
                                    ->after('starting_at')
                                    ->required()
                                    ->native(false)
                                    ->displayFormat('M d, Y - h:i A'),
                                
                                Placeholder::make('duration')
                                    ->label('Event Duration')
                                    ->content(fn($get) => calculateRuntime($get('starting_at'), $get('ending_at')))
                                    ->columnSpan('full'),
                            ]),
                    ]),

                Section::make('Event Access')
                    ->description('Configure how participants can access this event')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('event_link')
                                    ->unique(ignoreRecord: true)
                                    ->url()
                                    ->placeholder('Event URL')
                                    ->helperText('The link where participants can access the event')
                                    ->columnSpan(1),

                                TextInput::make('event_password')
                                    ->password()
                                    ->revealable()
                                    ->placeholder('Access password (optional)')
                                    ->helperText('Optional password for event access')
                                    ->columnSpan(1),
                            ]),

                        Grid::make(2)
                            ->schema([
                                ToggleButtons::make('participation_scope')
                                    ->columnSpan('full')
                                    ->enum(ParticipationScope::class)
                                    ->options(ParticipationScope::class)
                                    ->default(ParticipationScope::OPEN_FOR_ALL)
                                    ->helperText('Who can participate in this event')
                                    ->inline()
                                    ->required(),

                                Checkbox::make('open_for_attendance')
                                    ->label('Open for Attendance')
                                    ->helperText('Check this if the event is ready for attendees to register')
                                    ->default(false)
                                    ->columnSpan(1),

                                Checkbox::make('strict_attendance')
                                    ->label('Strict Attendance')
                                    ->helperText('If enabled, users who didn\'t give attendance won\'t have their solve counts counted')
                                    ->default(false)
                                    ->columnSpan(1),
                            ]),
                    ]),

                Section::make('Event History')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Placeholder::make('created_at')
                                    ->label('Created Date')
                                    ->content(fn(?Event $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                                Placeholder::make('updated_at')
                                    ->label('Last Modified Date')
                                    ->content(fn(?Event $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                            ]),
                    ])->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('starting_at', 'desc')
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('type')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
            
                    ->sortable(),

                TextColumn::make('starting_at')
                    ->sortable()
                    ->timezone('Asia/Dhaka')
                    ->dateTime('M d, Y - h:i A')
                    ->label('Starting Date'),

                TextColumn::make('ending_at')
                    ->timezone('Asia/Dhaka')
                    ->dateTime('M d, Y - h:i A')
                    ->label('Ending Date')     
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('participation_scope')
                    ->badge()
    
                    ->sortable(),

                ToggleColumn::make('open_for_attendance')
                    ->label('Open')
                    ->sortable(),

                ToggleColumn::make('strict_attendance')
                    ->label('Strict')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('event_link')
                    ->label('Link')
                    ->url(fn($record) => $record->event_link ? 'https://' . $record->event_link : null)
                    ->openUrlInNewTab()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(EventType::class)
                    ->label('Event Type'),
                    
                SelectFilter::make('status')
                    ->options(Visibility::class)
                    ->multiple(),

                SelectFilter::make('participation_scope')
                    ->options(ParticipationScope::class)
                    ->label('Participation'),
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
            ->emptyStateIcon('heroicon-o-calendar')
            ->emptyStateHeading('No events yet')
            ->emptyStateDescription('Once you create events, they will appear here.')
            ->emptyStateActions([
                \Filament\Tables\Actions\CreateAction::make()
                    ->label('Create event')
                    ->icon('heroicon-o-plus'),
            ])
            ->striped()
            ->poll('60s')
            ->paginated([10, 25, 50, 100]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'description'];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}

function calculateRuntime($start, $end): ?string
{
    if (!$start || !$end) {
        return 'N/A'; // Placeholder text when either time is not set
    }

    $start = Carbon::parse($start);
    $end = Carbon::parse($end);

    try {
        $diff = $start->diff($end);
        
        $parts = [];
        if ($diff->d > 0) $parts[] = $diff->d . ' ' . ($diff->d > 1 ? 'days' : 'day');
        if ($diff->h > 0) $parts[] = $diff->h . ' ' . ($diff->h > 1 ? 'hours' : 'hour');
        if ($diff->i > 0) $parts[] = $diff->i . ' ' . ($diff->i > 1 ? 'minutes' : 'minute');
        
        return !empty($parts) ? implode(', ', $parts) : 'Less than a minute';
    } catch (Exception $e) {
        return 'Calculation error: ' . $e->getMessage();
    }
}
