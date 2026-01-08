<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'topic',
        'difficulty',
        'prompt',
        'code_snippet',
        'image_url',
        'choices',
        'correct_index',
        'explanation',
        'tip',
        'is_active',
    ];

    protected $casts = [
        'choices' => 'array',
        'is_active' => 'boolean',
    ];
}
