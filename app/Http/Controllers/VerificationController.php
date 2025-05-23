<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /**
     * Constructor - no middleware
     */
    public function __construct()
    {
        // No middleware here
    }
    /**
     * Show pending verification status page
     */
    public function showPending()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $user = Auth::user();
        $member = $user->member;
        
        if ($member->isVerified()) {
            return redirect()->route('profile.dashboard');
        } elseif ($member->isRejected()) {
            return redirect()->route('verification.rejected');
        }
        
        return view('auth.verification.pending', compact('user', 'member'));
    }
    
    /**
     * Show rejected verification status page
     */
    public function showRejected()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $user = Auth::user();
        $member = $user->member;
        
        if ($member->isVerified()) {
            return redirect()->route('profile.dashboard');
        } elseif ($member->isPending()) {
            return redirect()->route('verification.pending');
        }
        
        return view('auth.verification.rejected', compact('user', 'member'));
    }
    
    /**
     * Admin interface for reviewing pending verification requests
     */
    public function adminIndex()
    {
        $pendingMembers = Member::where('verification_status', 'pending')
            ->with('user')
            ->latest()
            ->get();
            
        $recentlyVerified = Member::where('verification_status', 'verified')
            ->whereNotNull('verified_at')
            ->with('user')
            ->latest('verified_at')
            ->take(5)
            ->get();
            
        $recentlyRejected = Member::where('verification_status', 'rejected')
            ->with('user')
            ->latest('updated_at')
            ->take(5)
            ->get();
        
        return view('admin.verification.index', compact('pendingMembers', 'recentlyVerified', 'recentlyRejected'));
    }
    
    /**
     * Show verification details for admin review
     */
    public function adminShow($id)
    {
        $member = Member::with('user')->findOrFail($id);
        
        return view('admin.verification.show', compact('member'));
    }
    
    /**
     * Process verification approval by admin
     */
    public function approve(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);
        
        $member->approve($request->notes);
        
        return redirect()->route('admin.verification.index')
            ->with('success', "Member {$member->username} has been verified successfully.");
    }
    
    /**
     * Process verification rejection by admin
     */
    public function reject(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);
        
        $member->reject($request->reason);
        
        return redirect()->route('admin.verification.index')
            ->with('success', "Member {$member->username} has been rejected.");
    }
    
    /**
     * Reset member to pending status (after rejection)
     */
    public function resetToPending(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);
        
        $member->setPending($request->notes);
        
        return redirect()->route('admin.verification.index')
            ->with('success', "Member {$member->username} has been reset to pending status.");
    }
}