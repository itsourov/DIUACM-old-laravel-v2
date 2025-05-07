<?php

namespace App\Models;

use App\Enums\Visibility;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
        'order',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [

            'status' => Visibility::class,
        ];
    }
}
