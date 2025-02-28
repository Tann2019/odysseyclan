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
    
    /**
     * Check if the member has a temporary discord ID
     */
    public function hasTemporaryDiscordId()
    {
        return str_starts_with($this->discord_id, 'temp_');
    }
    
    /**
     * Add an achievement to the member
     */
    public function addAchievement(array $achievement)
    {
        // Validate achievement structure
        if (!$this->validateAchievement($achievement)) {
            return false;
        }
        
        $achievements = $this->achievements ?? [];
        $achievements[] = $achievement;
        
        $this->achievements = $achievements;
        return $this->save();
    }
    
    /**
     * Remove an achievement by ID
     */
    public function removeAchievement(string $achievementId)
    {
        $achievements = $this->achievements ?? [];
        
        $filtered = array_filter($achievements, function ($achievement) use ($achievementId) {
            return $achievement['id'] !== $achievementId;
        });
        
        $this->achievements = array_values($filtered);
        return $this->save();
    }
    
    /**
     * Validate achievement structure
     */
    private function validateAchievement(array $achievement)
    {
        $requiredKeys = ['id', 'name', 'description', 'date_earned'];
        
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $achievement)) {
                return false;
            }
        }
        
        return true;
    }
}
