<?php

use App\Http\Controllers\MatchmakingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MatchmakingController::class, 'index'])->name('matchmaker.index');
Route::post('/calculate', [MatchmakingController::class, 'calculate'])->name('matchmaker.calculate');
