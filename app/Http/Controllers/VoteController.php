<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $cookieVotes = env('COOKIE_VOTES', 'votes');
        
        $votedFeedback = json_decode($request->cookie($cookieVotes, '[]'), true);

        if (in_array($id, $votedFeedback)) {
            return redirect()->back()->with('error', __('messages.vote_error'));
        }

        $votedFeedback[] = $id;
        
        $cookie = Cookie::make($cookieVotes, json_encode($votedFeedback), 60 * 24 * 365); // 1 año de duración
        
        Vote::create([
            'feedback_id' => $id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', __('messages.vote_success'))->withCookie($cookie);

    }
}
