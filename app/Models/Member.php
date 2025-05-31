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
        'user_id',
        'verification_status',
        'verification_notes',
        'verified_at'
    ];

    protected $casts = [
        'achievements' => 'array',
        'is_active' => 'boolean',
        'verified_at' => 'datetime'
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
    
    /**
     * Check if member is pending verification
     */
    public function isPending()
    {
        return $this->verification_status === 'pending';
    }
    
    /**
     * Check if member is verified
     */
    public function isVerified()
    {
        return $this->verification_status === 'verified';
    }
    
    /**
     * Check if member is rejected
     */
    public function isRejected()
    {
        return $this->verification_status === 'rejected';
    }
    
    /**
     * Approve member verification
     */
    public function approve($notes = null)
    {
        $this->verification_status = 'verified';
        $this->verification_notes = $notes;
        $this->verified_at = now();
        return $this->save();
    }
    
    /**
     * Reject member verification
     */
    public function reject($reason)
    {
        $this->verification_status = 'rejected';
        $this->verification_notes = $reason;
        return $this->save();
    }
    
    /**
     * Set member to pending status
     */
    public function setPending($notes = null)
    {
        $this->verification_status = 'pending';
        $this->verification_notes = $notes;
        $this->verified_at = null;
        return $this->save();
    }

    /**
     * Get all event signups for this member
     */
    public function eventSignups()
    {
        return $this->hasMany(EventSignup::class);
    }

    /**
     * Get current/active event signups
     */
    public function activeEventSignups()
    {
        return $this->hasMany(EventSignup::class)->where('status', 'registered');
    }
}
