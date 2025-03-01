<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Constructor - no middleware
     */
    public function __construct()
    {
        // No middleware here
    }
    
    /**
     * Show dashboard for admins
     */
    public function dashboard()
    {
        // Check if user is an admin
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        if (!$user->isAdmin()) {
            return redirect()->route('home')
                ->with('error', 'You do not have permission to access this area.');
        }
        $totalMembers = Member::count();
        $pendingVerifications = Member::where('verification_status', 'pending')->count();
        
        // Get latest members
        $latestMembers = Member::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact('totalMembers', 'pendingVerifications', 'latestMembers'));
    }
    
    /**
     * Show admin creation form
     */
    public function showCreateAdmin()
    {
        // Check if user is an admin
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        if (!$user->isAdmin()) {
            return redirect()->route('home')
                ->with('error', 'You do not have permission to access this area.');
        }
        return view('admin.create-admin');
    }
    
    /**
     * Process admin creation
     */
    public function storeAdmin(Request $request)
    {
        // Check if user is an admin
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        if (!$user->isAdmin()) {
            return redirect()->route('home')
                ->with('error', 'You do not have permission to access this area.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'username' => 'required|string|max:255',
            'discord_id' => 'required|string|max:255|unique:members',
        ]);
        
        // Create the user with admin privileges
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => true,
        ]);
        
        // Create the member profile
        Member::create([
            'user_id' => $user->id,
            'discord_id' => $request->discord_id,
            'username' => $request->username,
            'rank' => 'commander', // Default admin rank
            'is_active' => true,
            'verification_status' => 'verified',
            'verified_at' => now(),
            'achievements' => [
                [
                    'id' => 'admin_role',
                    'name' => 'Administrator',
                    'description' => 'Site administrator with full privileges',
                    'date_earned' => now()->format('Y-m-d')
                ]
            ]
        ]);
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'New admin created successfully.');
    }
}