<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSolveStatOnEvent extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'solve_count',
        'upsolve_count',
        'participation',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    protected function casts(): array
    {
        return [
            'participation' => 'boolean',
        ];
    }
}
