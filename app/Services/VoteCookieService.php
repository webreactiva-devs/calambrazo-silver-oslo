<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class VoteCookieService
{
    protected $cookieName;

    public function __construct()
    {
        $this->cookieName = config('app.cookie_name');
    }

    public function hasVoted(Request $request, $feedbackId)
    {
        $votedFeedback = json_decode($request->cookie($this->cookieName, '[]'), true);

        return in_array($feedbackId, $votedFeedback);
    }

    public function createVoteCookie(Request $request, $feedbackId)
    {
        $votedFeedback = json_decode($request->cookie($this->cookieName, '[]'), true);
        $votedFeedback[] = $feedbackId;

        return Cookie::make($this->cookieName, json_encode($votedFeedback), 60 * 24 * 365);
    }
}
