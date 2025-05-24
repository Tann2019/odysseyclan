<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Constructor - no middleware
     */
    public function __construct()
    {
        // No middleware here
    }
    /**
     * Display a listing of all members for public view.
     */
    public function index(Request $request)
    {
        // Check if user is verified member
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        if (!$user->isAdmin() && (!$user->member || !$user->member->isVerified())) {
            if (!$user->member) {
                return redirect()->route('profile.edit')
                    ->with('error', 'You must complete your profile first.');
            }
            
            if ($user->member->isPending()) {
                return redirect()->route('verification.pending');
            } elseif ($user->member->isRejected()) {
                return redirect()->route('verification.rejected');
            }
            
            return redirect()->route('verification.pending');
        }
        $query = Member::where('is_active', true);

        // Handle search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Handle rank filter
        if ($rank = $request->input('rank')) {
            $query->where('rank', $rank);
        }

        // Handle sorting
        $sort = $request->input('sort', 'rank');
        $query->when($sort, function($q) use ($sort) {
            switch($sort) {
                case 'username':
                    return $q->orderBy('username');
                case 'joined':
                    return $q->orderBy('created_at', 'desc');
                case 'rank':
                    return $q->orderByRaw("CASE rank 
                        WHEN 'commander' THEN 1 
                        WHEN 'captain' THEN 2 
                        WHEN 'veteran' THEN 3 
                        WHEN 'warrior' THEN 4 
                        WHEN 'recruit' THEN 5 
                        ELSE 6 
                    END");
                default:
                    return $q->orderBy('username');
            }
        });

        $members = $query->get();
        $ranks = ['commander', 'captain', 'veteran', 'warrior', 'recruit'];

        return view('members.index', compact('members', 'ranks'));
    }
    
    /**
     * Display a listing of all members for admin view.
     */
    public function adminIndex(Request $request)
    {
        $query = Member::query();

        // Handle search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('discord_id', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Handle rank filter
        if ($rank = $request->input('rank')) {
            $query->where('rank', $rank);
        }
        
        // Handle active/inactive filter
        if ($request->has('active')) {
            $isActive = filter_var($request->input('active'), FILTER_VALIDATE_BOOLEAN);
            $query->where('is_active', $isActive);
        }

        // Include user relationship
        $query->with('user');

        // Handle sorting
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');
        
        if ($sort === 'rank') {
            $query->orderByRaw("CASE rank 
                WHEN 'commander' THEN 1 
                WHEN 'captain' THEN 2 
                WHEN 'veteran' THEN 3 
                WHEN 'warrior' THEN 4 
                WHEN 'recruit' THEN 5 
                ELSE 6 
            END");
        } else {
            $query->orderBy($sort, $direction);
        }

        $members = $query->paginate(15);
        $ranks = ['commander', 'captain', 'veteran', 'warrior', 'recruit'];

        return view('admin.members.index', compact('members', 'ranks'));
    }
    
    /**
     * Display the specified member.
     */
    public function show($id)
    {
        $member = Member::with('user')->findOrFail($id);
        
        return view('admin.members.show', compact('member'));
    }
    
    /**
     * Show the form for editing the specified member.
     */
    public function edit($id)
    {
        $member = Member::with('user')->findOrFail($id);
        $ranks = ['commander', 'captain', 'veteran', 'warrior', 'recruit'];
        
        return view('admin.members.edit', compact('member', 'ranks'));
    }
    
    /**
     * Update the specified member in storage.
     */
    public function update(Request $request, $id, ImageUploadService $imageUploadService)
    {
        $member = Member::findOrFail($id);
        
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'discord_id' => 'required|string|max:255|unique:members,discord_id,' . $member->id,
            'rank' => 'required|string|in:commander,captain,veteran,warrior,recruit',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'remove_avatar' => 'nullable|boolean',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($member->avatar_url) {
                $imageUploadService->deleteImage($member->avatar_url);
            }
            
            // Upload new avatar
            $avatarPath = $imageUploadService->uploadAvatar($request->file('avatar'));
            if ($avatarPath) {
                $validated['avatar_url'] = $avatarPath;
            }
        } elseif ($request->boolean('remove_avatar')) {
            // Remove current avatar
            if ($member->avatar_url) {
                $imageUploadService->deleteImage($member->avatar_url);
                $validated['avatar_url'] = null;
            }
        }

        // Remove upload-specific fields from validation data
        unset($validated['avatar'], $validated['remove_avatar']);
        
        $member->update($validated);
        
        return redirect()->route('admin.members.index')
            ->with('success', 'Member updated successfully.');
    }
    
    /**
     * Remove the specified member from storage.
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        
        // Instead of deleting, we can make them inactive
        $member->update(['is_active' => false]);
        
        return redirect()->route('admin.members.index')
            ->with('success', 'Member deactivated successfully.');
    }
}
