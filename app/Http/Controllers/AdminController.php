<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use App\Models\News;
use App\Models\Event;
use App\Models\GalleryImage;
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
        // Statistics
        $totalMembers = Member::count();
        $pendingVerifications = Member::where('verification_status', 'pending')->count();
        $activeEvents = Event::active()->count();
        $publishedNews = News::published()->count();
        $totalImages = GalleryImage::count();
        
        // Get latest members
        $latestMembers = Member::with('user')
            ->latest()
            ->take(5)
            ->get();
            
        // Recent activity
        $recentNews = News::with('author')->latest()->take(3)->get();
        $upcomingEvents = Event::active()->upcoming()->take(3)->get();
        
        return view('admin.dashboard', compact(
            'totalMembers', 
            'pendingVerifications', 
            'activeEvents',
            'publishedNews',
            'totalImages',
            'latestMembers',
            'recentNews',
            'upcomingEvents'
        ));
    }
    
    /**
     * Show admin creation form
     */
    public function showCreateAdmin()
    {
        return view('admin.create-admin');
    }
    
    /**
     * Process admin creation
     */
    public function storeAdmin(Request $request)
    {
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