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
}