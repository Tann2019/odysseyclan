<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'discord_id',
        'username',
        'rank',
        'avatar_url',
        'description',
        'achievements',
        'is_active'
    ];

    protected $casts = [
        'achievements' => 'array',
        'is_active' => 'boolean'
    ];
}
