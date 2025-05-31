<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'image_url',
        'event_date',
        'registration_deadline',
        'max_participants',
        'is_active',
        'is_featured',
        'additional_info',
        'created_by',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'registration_deadline' => 'datetime',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'additional_info' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>', now());
    }

    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'tournament' => 'danger',
            'training' => 'success',
            'special' => 'warning',
            default => 'primary'
        };
    }

    public function getDaysLeftAttribute()
    {
        if ($this->event_date->isPast()) {
            return 0;
        }
        
        return now()->diffInDays($this->event_date);
    }

    public function signups()
    {
        return $this->hasMany(EventSignup::class);
    }

    public function registeredSignups()
    {
        return $this->hasMany(EventSignup::class)->where('status', 'registered');
    }

    public function getRegisteredCountAttribute()
    {
        return $this->registeredSignups()->count();
    }

    public function getSpotsRemainingAttribute()
    {
        if (!$this->max_participants) {
            return null;
        }
        
        return max(0, $this->max_participants - $this->registered_count);
    }

    public function isFull()
    {
        if (!$this->max_participants) {
            return false;
        }
        
        return $this->registered_count >= $this->max_participants;
    }

    public function canSignUp()
    {
        return $this->is_active 
            && !$this->event_date->isPast() 
            && (!$this->registration_deadline || !$this->registration_deadline->isPast())
            && !$this->isFull();
    }

    public function isUserSignedUp($memberId)
    {
        return $this->signups()
            ->where('member_id', $memberId)
            ->where('status', 'registered')
            ->exists();
    }

    public function signUpMember($memberId, $notes = null)
    {
        if (!$this->canSignUp() || $this->isUserSignedUp($memberId)) {
            return false;
        }

        return $this->signups()->create([
            'member_id' => $memberId,
            'notes' => $notes,
            'status' => 'registered',
            'signed_up_at' => now(),
        ]);
    }

    public function cancelSignup($memberId)
    {
        $signup = $this->signups()
            ->where('member_id', $memberId)
            ->where('status', 'registered')
            ->first();

        if ($signup) {
            $signup->cancel();
            return true;
        }

        return false;
    }
}