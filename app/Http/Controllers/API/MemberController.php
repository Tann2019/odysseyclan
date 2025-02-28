<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class MemberController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    
    /**
     * Get a listing of active members
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Member::where('is_active', true)->get()
        ]);
    }

    /**
     * Get a specific member by discord_id
     */
    public function show($discord_id)
    {
        $member = Member::where('discord_id', $discord_id)->firstOrFail();
        return response()->json([
            'success' => true,
            'data' => $member
        ]);
    }

    /**
     * Update a member's profile
     */
    public function update(Request $request, $discord_id)
    {
        try {
            $member = Member::where('discord_id', $discord_id)->firstOrFail();
            
            // Check if authenticated user owns this member profile or is an admin
            if (Auth::id() !== $member->user_id && !Auth::user()->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }
            
            // Validate the request
            $validated = $request->validate([
                'username' => 'sometimes|string|max:255',
                'avatar_url' => 'sometimes|nullable|url',
                'description' => 'sometimes|nullable|string|max:1000',
                'achievements' => 'sometimes|nullable|array',
                'achievements.*.id' => 'required|string',
                'achievements.*.name' => 'required|string',
                'achievements.*.description' => 'required|string',
                'achievements.*.date_earned' => 'required|date',
            ]);
            
            // Only admins can update rank and active status
            if (Auth::user()->isAdmin()) {
                $validated = array_merge(
                    $validated, 
                    $request->validate([
                        'rank' => 'sometimes|string|in:recruit,warrior,veteran,captain,commander',
                        'is_active' => 'sometimes|boolean'
                    ])
                );
            }
            
            $member->update($validated);

            return response()->json([
                'success' => true,
                'data' => $member
            ]);
            
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Add a new achievement to a member
     */
    public function addAchievement(Request $request, $discord_id)
    {
        try {
            $member = Member::where('discord_id', $discord_id)->firstOrFail();
            
            // Check if authenticated user owns this member profile or is an admin
            if (Auth::id() !== $member->user_id && !Auth::user()->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }
            
            // Validate the achievement
            $achievement = $request->validate([
                'id' => 'required|string',
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'date_earned' => 'required|date',
                'icon' => 'sometimes|nullable|string'
            ]);
            
            // Add the achievement
            $result = $member->addAchievement($achievement);
            
            if ($result) {
                return response()->json([
                    'success' => true,
                    'data' => $member,
                    'message' => 'Achievement added successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add achievement'
                ], 422);
            }
            
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Remove an achievement from a member
     */
    public function removeAchievement(Request $request, $discord_id, $achievement_id)
    {
        try {
            $member = Member::where('discord_id', $discord_id)->firstOrFail();
            
            // Check if authenticated user owns this member profile or is an admin
            if (Auth::id() !== $member->user_id && !Auth::user()->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }
            
            // Remove the achievement
            $result = $member->removeAchievement($achievement_id);
            
            if ($result) {
                return response()->json([
                    'success' => true,
                    'data' => $member,
                    'message' => 'Achievement removed successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to remove achievement'
                ], 422);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
