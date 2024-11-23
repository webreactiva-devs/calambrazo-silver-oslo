<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use App\Services\VoteCookieService;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id, VoteCookieService $voteCookieService)
    {
        // Extraida la lógica de la cookie a un servicio.
        if ($voteCookieService->hasVoted($request, $id)) {
            return redirect()->back()->with('error', __('messages.vote_error'));
        }
    
        $cookie = $voteCookieService->createVoteCookie($request, $id);
        
        Vote::create([
            'feedback_id' => $id,
            'user_id' => Auth::id(),
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', __('messages.vote_success'))->withCookie($cookie);

    }
}
