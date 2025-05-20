<?php

namespace App\Models;

use App\Enums\Visibility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tracker extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
        'order',
    ];

    protected function casts(): array
    {
        return [

            'status' => Visibility::class,

        ];
    }

    public function rankLists(): HasMany|Tracker
    {
        return $this->hasMany(RankList::class);
    }
}
