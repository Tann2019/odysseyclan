<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSignup extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'member_id',
        'notes',
        'status',
        'signed_up_at',
    ];

    protected $casts = [
        'signed_up_at' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function scopeRegistered($query)
    {
        return $query->where('status', 'registered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeAttended($query)
    {
        return $query->where('status', 'attended');
    }

    public function isRegistered()
    {
        return $this->status === 'registered';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function hasAttended()
    {
        return $this->status === 'attended';
    }

    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
    }

    public function markAttended()
    {
        $this->update(['status' => 'attended']);
    }

    public function markNoShow()
    {
        $this->update(['status' => 'no_show']);
    }
}