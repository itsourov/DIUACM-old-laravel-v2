<?php

namespace App\Models;

use App\Enums\EventType;
use App\Enums\ParticipationScope;
use App\Enums\Visibility;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'starting_at',
        'ending_at',
        'event_link',
        'event_password',
        'open_for_attendance',
        'type',
        'participation_scope',
    ];

    protected function casts(): array
    {
        return [
            'starting_at' => 'datetime',
            'open_for_attendance' => 'boolean',
            'status' => Visibility::class,
            'type' => EventType::class,
            'participation_scope' => ParticipationScope::class,
        ];
    }
}
