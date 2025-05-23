<?php

namespace App\Http\Controllers;

use App\Models\Streamer;
use App\Services\TwitchService;
use Illuminate\Http\Request;

class StreamerController extends Controller
{
    public function index()
    {
        $streamers = Streamer::orderBy('priority', 'desc')->get();
        return view('admin.streamers.index', compact('streamers'));
    }

    public function create()
    {
        return view('admin.streamers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'twitch_username' => 'required|string|max:255|unique:streamers',
            'display_name' => 'required|string|max:255',
            'priority' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        Streamer::create($validated);

        return redirect()->route('admin.streamers.index')
            ->with('success', 'Streamer added successfully.');
    }

    public function edit(Streamer $streamer)
    {
        return view('admin.streamers.edit', compact('streamer'));
    }

    public function update(Request $request, Streamer $streamer)
    {
        $validated = $request->validate([
            'twitch_username' => 'required|string|max:255|unique:streamers,twitch_username,' . $streamer->id,
            'display_name' => 'required|string|max:255',
            'priority' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        $streamer->update($validated);

        return redirect()->route('admin.streamers.index')
            ->with('success', 'Streamer updated successfully.');
    }

    public function destroy(Streamer $streamer)
    {
        $streamer->delete();

        return redirect()->route('admin.streamers.index')
            ->with('success', 'Streamer deleted successfully.');
    }

    public function refreshStatus(Streamer $streamer, TwitchService $twitchService)
    {
        $success = $twitchService->updateStreamerStatus($streamer);
        
        if ($success) {
            $twitchService->clearLiveStreamerCache();
            return back()->with('success', 'Stream status updated successfully.');
        } else {
            return back()->with('error', 'Failed to update stream status.');
        }
    }

    public function refreshAll(TwitchService $twitchService)
    {
        $updated = $twitchService->updateAllStreamStatuses();
        $twitchService->clearLiveStreamerCache();
        
        return back()->with('success', "Updated {$updated} streamer statuses.");
    }
}