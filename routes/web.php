<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FeedbackController::class, 'index'])->name('home');

Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/feedback/{feedback}/edit', [FeedbackController::class,'edit'])->name('feedback.edit');
Route::put('/feedback/{feedback}', [FeedbackController::class,'update'])->name('feedback.update');
Route::delete('feedback/{feedback}', [FeedbackController::class,'destroy'])->name('feedback.destroy');

Route::post('/vote/{id}', [VoteController::class, 'store'])->name('vote.store');

require __DIR__.'/auth.php';
