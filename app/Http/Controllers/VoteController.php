<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $cookieName = 'votes';
        
        $votedFeedback = json_decode($request->cookie($cookieName, '[]'), true);

        if (in_array($id, $votedFeedback)) {
            return redirect()->back()->with('error', 'Ya has votado por este feedback');
        }

        $votedFeedback[] = $id;
        
        $cookie = Cookie::make($cookieName, json_encode($votedFeedback), 60 * 24 * 365); // 1 año de duración
        
        Vote::create([
            'feedback_id' => $id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Voto registrado con éxito')->withCookie($cookie);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
