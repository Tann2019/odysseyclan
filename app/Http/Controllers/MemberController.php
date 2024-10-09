<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();

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
}
