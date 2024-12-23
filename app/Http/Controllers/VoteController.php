<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use App\Services\VoteCookieService;
use App\Services\VoteDeviceService;
use App\Services\VoteIpService;
use App\Services\VoteFingerprintService;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(
        Request $request, $id, 
        VoteCookieService $voteCookieService, 
        VoteDeviceService $voteDeviceService,
        VoteIpService $voteIpService,
        VoteFingerprintService $voteFingerprintService
        )
        {
        $device = $voteDeviceService->detectDevice();
        $ip = $request->ip();
        $fingerprint = $request->input('fingerprint');
        
        // 0.COOKIE. Extraemos la lógica de la cookie a un servicio.
        if ($voteCookieService->hasVoted($request, $id)) {
            return redirect()->back()->with([
                'error' => __('messages.vote_error'),
                'vote_debug' => 'cookie',
            ]);
        }
    
        $cookie = $voteCookieService->createVoteCookie($request, $id);

        // 1.DISPOSITIVO. Comprobamos a través del servicio si ya ha votado con este dispositivo desde una misma IP.
        if ($voteDeviceService->hasVotedWithDevice($device, $id, $ip)) {
            return redirect()->back()->with('error', __('messages.vote_error'))
            ->with('vote_debug', 'device');
        }

        // 2.IP. Comprobamos a través del servicio si ya ha votado con esta IP.
        if ($voteIpService->hasVotedWithIp($id, $ip)) {
            return redirect()->back()->with('error', __('messages.vote_error'))
            ->with('vote_debug', 'ip');
        }

        // 3.FINGERPRINT. Comprobamos si ya ha votado con este fingerprint.
        if ($voteFingerprintService->hasVotedWithFingerprint($fingerprint, $id)) {
            return redirect()->back()->with('error', __('messages.vote_error'))
            ->with('vote_debug', 'fingerprint');
        }

        Vote::create([
            'feedback_id' => $id,
            'user_id' => Auth::id(),
            'ip_address' => $ip,
            'device' => $device,
            'fingerprint' => $fingerprint,
        ]);

        return redirect()->back()->with('success', __('messages.vote_success'))->withCookie($cookie);

    }
}
