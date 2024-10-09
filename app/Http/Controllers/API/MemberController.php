<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Member::where('is_active', true)->get()
        ]);
    }

    public function show($discord_id)
    {
        $member = Member::where('discord_id', $discord_id)->firstOrFail();
        return response()->json([
            'success' => true,
            'data' => $member
        ]);
    }

    public function update(Request $request, $discord_id)
    {
        $member = Member::where('discord_id', $discord_id)->firstOrFail();
        
        // In production, add validation and authentication here
        $member->update($request->only([
            'username',
            'rank',
            'avatar_url',
            'description',
            'achievements'
        ]));

        return response()->json([
            'success' => true,
            'data' => $member
        ]);
    }
}
