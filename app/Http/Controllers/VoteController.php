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
        // Obtenemos el dispositivo e IP del usuario y el fingerprint.
        $device = $voteDeviceService->detectDevice();
        $ip = $request->ip();
        $fingerprint = $request->input('fingerprint');
        
        // 0.COOKIE. Extraemos la lógica de la cookie a un servicio.
        if ($voteCookieService->hasVoted($request, $id)) {
            return redirect()->back()->with('error', __('messages.vote_error'));
        }
    
        $cookie = $voteCookieService->createVoteCookie($request, $id);

        // 1.DISPOSITIVO. Comprobamos a través del servicio si ya ha votado con este dispositivo desde una misma IP.
        if ($voteDeviceService->hasVotedWithDevice($device, $id, $ip)) {
            return redirect()->back()->with('error', __('messages.device_vote_error'));
        }

        // 2.IP. Comprobamos a través del servicio si ya ha votado con esta IP.
        if ($voteIpService->hasVotedWithIp($id, $ip)) {
            return redirect()->back()->with('error', __('messages.ip_vote_error'));
        }

        // 3.FINGERPRINT. Comprobamos si ya ha votado con este fingerprint.
        // Verificar si ya votó con fingerprint
        if ($voteFingerprintService->hasVotedWithFingerprint($fingerprint, $id)) {
            return redirect()->back()->with('error', __('messages.fingerprint_vote_error'));
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
