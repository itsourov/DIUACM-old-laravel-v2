<?php

namespace App\Models;

use App\Enums\Visibility;
use Illuminate\Database\Eloquent\Model;

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
    public function rankLists(): \Illuminate\Database\Eloquent\Relations\HasMany|Tracker
    {
        return $this->hasMany(RankList::class);
    }
}
