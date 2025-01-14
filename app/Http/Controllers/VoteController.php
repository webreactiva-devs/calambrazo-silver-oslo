<?php

namespace App\Http\Controllers;

use App\Services\DeviceVoteValidator;
use Illuminate\Http\Request;
use App\Models\Vote;
use App\Services\VoteCookieService;
use App\Services\VoteDeviceService;
use App\Services\VoteIpService;
use App\Services\VoteFingerprintService;
use App\Services\VoteValidator;
use App\Services\IpVoteValidator;
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
        $cookie = $voteCookieService->createVoteCookie($request, $id);
        
        // // 0.COOKIE. Extraemos la lógica de la cookie a un servicio.
        // if ($voteCookieService->hasVoted($request, $id)) {
        //     return redirect()->back()->with([
        //         'error' => __('messages.vote_error'),
        //         'vote_debug' => 'cookie',
        //     ]);
        // }
    
        $data = [
            'request' => $request,
            'feedback_id' => $id,
            'user_id' => Auth::id(),
            'ip_address' => $ip,
            'device' => $device,
            'fingerprint' => $fingerprint,
        ];
        
        
        $validator = new VoteValidator([
            new VoteCookieService(),
            new VoteDeviceService(),
            new VoteIpService(),
            new VoteFingerprintService(),
        ]);        
        
        $isValid = $validator->validate($data);

        if (!$isValid) {
            return redirect()->back()->with([
                'error' => __('messages.vote_error'),
                'vote-debug' => 'error',
            ]);
        }


    

        Vote::create([
            'feedback_id' => $id,
            'user_id' => Auth::id(),
            'ip_address' => $ip,
            'device' => $device,
            'fingerprint' => $fingerprint,
        ]);

        return redirect()->back()->with('success', __('messages.vote_success'))
        ->withCookie($cookie);

    }
}
