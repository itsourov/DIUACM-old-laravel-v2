<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RankList extends Model
{
    protected $fillable = [
        'tracker_id',
        'keyword',
        'description',
        'weight_of_upsolve',
        'order',
        'is_archived',
    ];

    public function tracker(): BelongsTo
    {
        return $this->belongsTo(Tracker::class);
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_rank_list', 'rank_list_id', 'event_id')
            ->withPivot('weight');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'rank_list_user', 'rank_list_id', 'user_id');
    }

    protected function casts(): array
    {
        return [
            'is_archived' => 'boolean',
        ];
    }
}
