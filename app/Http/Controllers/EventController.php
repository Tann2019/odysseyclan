<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventSignup;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('creator')
            ->latest()
            ->paginate(15);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $types = ['tournament', 'training', 'special', 'community'];
        return view('admin.events.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:tournament,training,special,community',
            'image_url' => 'nullable|url',
            'event_date' => 'required|date|after:now',
            'registration_deadline' => 'nullable|date|before:event_date',
            'max_participants' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['created_by'] = Auth::id();

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $types = ['tournament', 'training', 'special', 'community'];
        return view('admin.events.edit', compact('event', 'types'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:tournament,training,special,community',
            'image_url' => 'nullable|url',
            'event_date' => 'required|date',
            'registration_deadline' => 'nullable|date|before:event_date',
            'max_participants' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    public function signup(Request $request, Event $event)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to sign up for events.');
        }

        $user = Auth::user();
        $member = $user->member;

        if (!$member || !$member->isVerified()) {
            return back()->with('error', 'You must be a verified member to sign up for events.');
        }

        if (!$event->canSignUp()) {
            return back()->with('error', 'This event is not available for signup.');
        }

        if ($event->isUserSignedUp($member->id)) {
            return back()->with('error', 'You are already signed up for this event.');
        }

        $validated = $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $signup = $event->signUpMember($member->id, $validated['notes'] ?? null);

        if ($signup) {
            return back()->with('success', 'Successfully signed up for the event!');
        }

        return back()->with('error', 'Unable to sign up for this event.');
    }

    public function cancelSignup(Event $event)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $member = $user->member;

        if (!$member) {
            return back()->with('error', 'Member profile not found.');
        }

        if ($event->cancelSignup($member->id)) {
            return back()->with('success', 'Your signup has been cancelled.');
        }

        return back()->with('error', 'Unable to cancel signup.');
    }

    public function showSignups(Event $event)
    {
        $signups = $event->signups()
            ->with('member')
            ->orderBy('signed_up_at')
            ->paginate(20);

        return view('admin.events.signups', compact('event', 'signups'));
    }

    public function updateSignupStatus(Request $request, Event $event, EventSignup $signup)
    {
        $validated = $request->validate([
            'status' => 'required|in:registered,cancelled,attended,no_show',
        ]);

        $signup->update(['status' => $validated['status']]);

        return back()->with('success', 'Signup status updated successfully.');
    }
}