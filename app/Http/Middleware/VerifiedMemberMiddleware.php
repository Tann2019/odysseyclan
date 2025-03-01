<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifiedMemberMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        // If admin, always allow access
        if ($user->isAdmin()) {
            return $next($request);
        }
        
        $member = $user->member;
        
        // If member doesn't exist yet or is not verified, redirect to appropriate page
        if (!$member || !$member->exists || !$member->isVerified()) {
            // Specific routes that should be accessible for pending members
            $allowedRoutes = [
                'verification.pending', 
                'verification.rejected', 
                'profile.edit', 
                'profile.update',
                'logout'
            ];
            
            if (!in_array($request->route()->getName(), $allowedRoutes)) {
                if ($member && $member->exists) {
                    if ($member->isPending()) {
                        return redirect()->route('verification.pending');
                    } elseif ($member->isRejected()) {
                        return redirect()->route('verification.rejected');
                    }
                }
                
                // Default fallback for any other unusual status
                return redirect()->route('verification.pending');
            }
        }
        
        return $next($request);
    }
}