<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchmakingRequest;
use App\Services\MatchmakingService;
use Illuminate\View\View;

class MatchmakingController extends Controller
{
    /**
     * Display the matchmaking calculator form page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('matchmaker');
    }

    /**
     * Process matchmaking calculation request.
     *
     * @param MatchmakingRequest $request
     * @param MatchmakingService $service
     * @return View
     */
    public function calculate(MatchmakingRequest $request, MatchmakingService $service): View
    {
        $validated = $request->validated();

        $result = $service->calculateMatch(
            $validated['person1_name'],
            $validated['person1_birthdate'],
            $validated['person2_name'],
            $validated['person2_birthdate']
        );

        return view('matchmaker', compact('result'));
    }
}
