<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GreenSheetProblem extends Model
{
    protected $fillable = [
        'title',
        'order',
        'oj',
        'oj_id',
        'oj_link',
        'editorial',
        'hint',
    ];
}
