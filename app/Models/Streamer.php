<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Streamer extends Model
{
    use HasFactory;

    protected $fillable = [
        'twitch_username',
        'display_name',
        'priority',
        'is_active',
        'is_live',
        'last_checked_at',
        'stream_data',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_live' => 'boolean',
        'last_checked_at' => 'datetime',
        'stream_data' => 'array',
    ];

    /**
     * Scope to get only active streamers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get live streamers ordered by priority
     */
    public function scopeLive($query)
    {
        return $query->where('is_live', true)
                    ->where('is_active', true)
                    ->orderBy('priority', 'desc');
    }

    /**
     * Scope to order by priority
     */
    public function scopeByPriority($query)
    {
        return $query->orderBy('priority', 'desc');
    }

    /**
     * Get the highest priority live streamer
     */
    public static function getCurrentLiveStreamer()
    {
        return static::live()->first();
    }

    /**
     * Check if any streamers are currently live
     */
    public static function hasLiveStreamers()
    {
        return static::live()->exists();
    }

    /**
     * Get all live streamers
     */
    public static function getLiveStreamers()
    {
        return static::live()->get();
    }

    /**
     * Get Twitch embed URL
     */
    public function getTwitchEmbedUrlAttribute()
    {
        $host = request()->getHost();
        return "https://player.twitch.tv/?channel={$this->twitch_username}&parent={$host}";
    }

    /**
     * Get Twitch channel URL
     */
    public function getTwitchChannelUrlAttribute()
    {
        return "https://www.twitch.tv/{$this->twitch_username}";
    }

    /**
     * Get stream title from stream data
     */
    public function getStreamTitleAttribute()
    {
        return $this->stream_data['title'] ?? '';
    }

    /**
     * Get game name from stream data
     */
    public function getGameNameAttribute()
    {
        return $this->stream_data['game_name'] ?? '';
    }

    /**
     * Get viewer count from stream data
     */
    public function getViewerCountAttribute()
    {
        return $this->stream_data['viewer_count'] ?? 0;
    }
}