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
        'is_active',
        'user_id'
    ];

    protected $casts = [
        'achievements' => 'array',
        'is_active' => 'boolean'
    ];
    
    /**
     * Get the user that owns the member profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
