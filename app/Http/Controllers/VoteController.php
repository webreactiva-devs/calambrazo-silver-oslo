<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use App\Services\VoteCookieService;
use App\Services\VoteDeviceService;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id, VoteCookieService $voteCookieService, VoteDeviceService $voteDeviceService)
    {
        // Obtenemos el dispositivo e IP del usuario.
        $device = $voteDeviceService->detectDevice();
        $ip = $request->ip();
        
        // Extraemos la lógica de la cookie a un servicio.
        if ($voteCookieService->hasVoted($request, $id)) {
            return redirect()->back()->with('error', __('messages.vote_error'));
        }
    
        $cookie = $voteCookieService->createVoteCookie($request, $id);

        // Comprobamos a través del servicio si ya ha votado con este dispositivo.
        if ($voteDeviceService->hasVotedWithDevice($device, $id, $ip)) {
            return redirect()->back()->with('error', __('messages.device_vote_error'));
        }

        Vote::create([
            'feedback_id' => $id,
            'user_id' => Auth::id(),
            'ip_address' => $ip,
            'device' => $device,
        ]);

        return redirect()->back()->with('success', __('messages.vote_success'))->withCookie($cookie);

    }
}
