<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }
    
    /**
     * Register a new user and member
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'discord_id' => 'required|string|max:255|unique:members',
            'username' => 'required|string|max:255',
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        $member = Member::create([
            'user_id' => $user->id,
            'discord_id' => $request->discord_id,
            'username' => $request->username,
            'rank' => 'recruit', // Default rank
            'achievements' => [],
            'is_active' => true,
            'verification_status' => 'pending',
            'verification_notes' => 'New registration awaiting verification',
        ]);
        
        Auth::login($user);
        
        return redirect()->route('verification.pending');
    }
    
    /**
     * Show the login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }
    
    /**
     * Authenticate a user
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('home'));
        }
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    
    /**
     * Logout a user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }
    
    /**
     * Show the profile dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        $member = $user->member;
        
        // If user doesn't have a member profile, create one with a temporary discord ID
        if (!$member->exists) {
            // Generate a unique temporary discord ID by prefixing with temp_ and user ID
            $tempDiscordId = 'temp_' . $user->id . '_' . uniqid();
            
            $member = Member::create([
                'user_id' => $user->id,
                'discord_id' => $tempDiscordId,
                'username' => $user->name,
                'rank' => 'recruit',
                'achievements' => [],
                'is_active' => true,
            ]);
            
            return redirect()->route('profile.edit')
                ->with('warning', 'Please update your profile with your actual Discord ID.');
        }
        
        return view('auth.dashboard', compact('user', 'member'));
    }
    
    /**
     * Show the profile edit form
     */
    public function editProfile()
    {
        $user = Auth::user();
        $member = $user->member;
        
        return view('auth.edit-profile', compact('user', 'member'));
    }
    
    /**
     * Update the user and member profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'discord_id' => 'required|string|max:255|unique:members,discord_id,' . ($user->member->id ?? ''),
            'username' => 'required|string|max:255',
            'description' => 'nullable|string',
            'avatar_url' => 'nullable|url',
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        if ($request->password) {
            $request->validate([
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);
            
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
        
        $user->member->update([
            'discord_id' => $request->discord_id,
            'username' => $request->username,
            'description' => $request->description,
            'avatar_url' => $request->avatar_url,
        ]);
        
        return redirect()->route('profile.dashboard')->with('success', 'Profile updated successfully!');
    }
}