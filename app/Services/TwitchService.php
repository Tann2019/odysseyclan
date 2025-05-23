<?php

namespace App\Services;

use App\Models\Streamer;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TwitchService
{
    private $clientId;
    private $clientSecret;
    private $accessToken;

    public function __construct()
    {
        $this->clientId = config('services.twitch.client_id');
        $this->clientSecret = config('services.twitch.client_secret');
    }

    /**
     * Get OAuth access token for Twitch API
     */
    private function getAccessToken()
    {
        if ($this->accessToken) {
            return $this->accessToken;
        }

        // Try to get token from cache
        $cachedToken = Cache::get('twitch_access_token');
        if ($cachedToken) {
            $this->accessToken = $cachedToken;
            return $this->accessToken;
        }

        try {
            $response = Http::post('https://id.twitch.tv/oauth2/token', [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->accessToken = $data['access_token'];
                
                // Cache token for slightly less than expiry time
                $expiresIn = $data['expires_in'] - 300; // 5 minutes buffer
                Cache::put('twitch_access_token', $this->accessToken, $expiresIn);
                
                return $this->accessToken;
            }

            Log::error('Failed to get Twitch access token', [
                'response' => $response->body()
            ]);
            return null;

        } catch (\Exception $e) {
            Log::error('Exception getting Twitch access token', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get user info by username
     */
    public function getUserByUsername($username)
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Client-Id' => $this->clientId,
            ])->get('https://api.twitch.tv/helix/users', [
                'login' => $username
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['data'][0] ?? null;
            }

            Log::warning('Failed to get Twitch user', [
                'username' => $username,
                'response' => $response->body()
            ]);
            return null;

        } catch (\Exception $e) {
            Log::error('Exception getting Twitch user', [
                'username' => $username,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get stream info for a user
     */
    public function getStreamByUserId($userId)
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Client-Id' => $this->clientId,
            ])->get('https://api.twitch.tv/helix/streams', [
                'user_id' => $userId
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['data'][0] ?? null;
            }

            Log::warning('Failed to get Twitch stream', [
                'user_id' => $userId,
                'response' => $response->body()
            ]);
            return null;

        } catch (\Exception $e) {
            Log::error('Exception getting Twitch stream', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Check if a user is currently live
     */
    public function isUserLive($username)
    {
        $user = $this->getUserByUsername($username);
        if (!$user) {
            return false;
        }

        $stream = $this->getStreamByUserId($user['id']);
        return $stream !== null;
    }

    /**
     * Get detailed stream info for a user
     */
    public function getStreamInfo($username)
    {
        $user = $this->getUserByUsername($username);
        if (!$user) {
            return null;
        }

        $stream = $this->getStreamByUserId($user['id']);
        if (!$stream) {
            return null;
        }

        return [
            'user_id' => $user['id'],
            'user_name' => $user['login'],
            'display_name' => $user['display_name'],
            'title' => $stream['title'],
            'game_name' => $stream['game_name'],
            'viewer_count' => $stream['viewer_count'],
            'started_at' => $stream['started_at'],
            'thumbnail_url' => $stream['thumbnail_url'],
        ];
    }

    /**
     * Update stream status for all active streamers
     */
    public function updateAllStreamStatuses()
    {
        $streamers = Streamer::active()->get();
        $updated = 0;

        foreach ($streamers as $streamer) {
            if ($this->updateStreamerStatus($streamer)) {
                $updated++;
            }
        }

        Log::info('Updated Twitch stream statuses', [
            'total_streamers' => $streamers->count(),
            'updated' => $updated
        ]);

        return $updated;
    }

    /**
     * Update stream status for a specific streamer
     */
    public function updateStreamerStatus(Streamer $streamer)
    {
        try {
            $streamInfo = $this->getStreamInfo($streamer->twitch_username);
            
            $isLive = $streamInfo !== null;
            $streamData = $streamInfo ? [
                'title' => $streamInfo['title'],
                'game_name' => $streamInfo['game_name'],
                'viewer_count' => $streamInfo['viewer_count'],
                'started_at' => $streamInfo['started_at'],
                'thumbnail_url' => $streamInfo['thumbnail_url'],
            ] : null;

            $streamer->update([
                'is_live' => $isLive,
                'stream_data' => $streamData,
                'last_checked_at' => now(),
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to update streamer status', [
                'streamer_id' => $streamer->id,
                'username' => $streamer->twitch_username,
                'error' => $e->getMessage()
            ]);
            
            // Update last_checked_at even on failure
            $streamer->update(['last_checked_at' => now()]);
            return false;
        }
    }

    /**
     * Get the current live streamer for homepage display
     */
    public function getCurrentLiveStreamer()
    {
        // Check cache first
        $cacheKey = 'current_live_streamer';
        $cached = Cache::get($cacheKey);
        
        if ($cached !== null) {
            return $cached;
        }

        // Get from database
        $liveStreamer = Streamer::getCurrentLiveStreamer();
        
        // Cache for 2 minutes
        Cache::put($cacheKey, $liveStreamer, 120);
        
        return $liveStreamer;
    }

    /**
     * Clear the current live streamer cache
     */
    public function clearLiveStreamerCache()
    {
        Cache::forget('current_live_streamer');
    }
}