<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar_url',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }
    
    /**
     * Get the member associated with the user
     */
    public function member()
    {
        return $this->hasOne(Member::class)->withDefault();
    }
    
    /**
     * Check if user is an admin
     */
    public function isAdmin()
    {
        return $this->is_admin === true;
    }
    
    /**
     * Get the user's avatar URL with fallback to default
     */
    public function getAvatarAttribute()
    {
        if ($this->avatar_url) {
            return $this->avatar_url;
        }
        
        // Generate a default avatar based on user's initials
        $initials = $this->getInitials();
        return "https://ui-avatars.com/api/?name={$initials}&size=200&background=8B0000&color=FFD700&bold=true";
    }
    
    /**
     * Get user initials for default avatar
     */
    public function getInitials()
    {
        $words = explode(' ', trim($this->name));
        $initials = '';
        
        foreach ($words as $word) {
            if (strlen($word) > 0) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }
        
        return substr($initials, 0, 2) ?: 'OC'; // Default to 'OC' for Odyssey Clan
    }
}
