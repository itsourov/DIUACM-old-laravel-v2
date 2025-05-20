<?php

namespace App\Models;

use App\Enums\ContestType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contest extends Model
{
    protected $fillable = [
        'name',
        'gallery_id',
        'contest_type',
        'location',
        'date',
        'description',
        'standings_url',
    ];

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'contest_type' => ContestType::class,
        ];
    }
}
