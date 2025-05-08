<?php

namespace App\Models;

use App\Enums\EventType;
use App\Enums\ParticipationScope;
use App\Enums\Visibility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'strict_attendance',
        'type',
        'participation_scope',
    ];

    public function rankLists(): BelongsToMany
    {
        return $this->belongsToMany(RankList::class, 'event_rank_list', 'event_id', 'rank_list_id')
            ->wherePivot('weight');
    }

    public function attendedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user_attendance', 'event_id', 'user_id')->withTimestamps();
    }

    protected function casts(): array
    {
        return [
            'starting_at' => 'datetime',
            'ending_at' => 'datetime',
            'open_for_attendance' => 'boolean',
            'strict_attendance' => 'boolean',
            'status' => Visibility::class,
            'type' => EventType::class,
            'participation_scope' => ParticipationScope::class,
        ];
    }
}
