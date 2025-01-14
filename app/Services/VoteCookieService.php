<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Contracts\VoteValidatorInterface;

class VoteCookieService implements VoteValidatorInterface
{
    protected $cookieName;

    public function __construct()
    {
        $this->cookieName = config('app.cookie_name');
    }

    public function hasVoted(array $data): bool
    {
        $feedbackId = $data['feedback_id'];
        $request = $data['request'];

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
