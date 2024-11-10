<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedback = Feedback::latest()->withCount('votes')->paginate(5);
        return view("home", data: compact("feedback"));
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();

        Feedback::create($validated);

        return redirect()->back()->with('success', 'Feedback creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feedback $feedback)
    {
        return view('feedback.edit', compact('feedback'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $feedback->update($validated);
        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
       Gate::authorize('delete', $feedback);

        $feedback->delete();

        return back();
    }
}
