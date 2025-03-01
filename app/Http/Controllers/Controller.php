<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

abstract class Controller
{
    /**
     * Check if the current user is an admin
     */
    protected function isAdmin()
    {
        return Auth::check() && Auth::user()->isAdmin();
    }
    
    /**
     * Check if the current user is a verified member
     */
    protected function isVerifiedMember()
    {
        if (!Auth::check()) {
            return false;
        }
        
        $user = Auth::user();
        
        // Admins are always considered verified members
        if ($user->isAdmin()) {
            return true;
        }
        
        $member = $user->member;
        return $member && $member->exists && $member->isVerified();
    }
    
    /**
     * Ensure the current user is a verified member or redirect
     */
    protected function ensureVerifiedMember(Request $request)
    {
        if ($this->isVerifiedMember()) {
            return true;
        }
        
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $member = Auth::user()->member;
        
        if ($member && $member->exists) {
            if ($member->isPending()) {
                return redirect()->route('verification.pending');
            } elseif ($member->isRejected()) {
                return redirect()->route('verification.rejected');
            }
        }
        
        // Default fallback
        return redirect()->route('verification.pending');
    }
    
    /**
     * Ensure the current user is an admin or redirect
     */
    protected function ensureAdmin()
    {
        if ($this->isAdmin()) {
            return true;
        }
        
        return redirect()->route('home')
            ->with('error', 'You do not have permission to access this area.');
    }
}
