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
        if (Auth::check()) {
            $user = Auth::user();
            $member = $user->member;
            
            // If admin, always allow access
            if ($user->isAdmin()) {
                return $next($request);
            }
            
            // If member doesn't exist yet or is not verified, redirect to appropriate page
            if (!$member->exists || !$member->isVerified()) {
                // Specific routes that should be accessible for pending members
                $allowedRoutes = [
                    'verification.pending', 
                    'verification.rejected', 
                    'profile.edit', 
                    'profile.update',
                    'logout'
                ];
                
                if (!in_array($request->route()->getName(), $allowedRoutes)) {
                    if ($member->isPending()) {
                        return redirect()->route('verification.pending');
                    } elseif ($member->isRejected()) {
                        return redirect()->route('verification.rejected');
                    } else {
                        // Default fallback for any other unusual status
                        return redirect()->route('verification.pending');
                    }
                }
            }
        }
        
        return $next($request);
    }
}