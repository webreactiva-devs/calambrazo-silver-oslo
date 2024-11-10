<?php


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FeedbackController::class, 'index'])->name('home');

Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/feedback/{feedback}/edit', [FeedbackController::class,'edit'])->name('feedback.edit');
Route::put('/feedback/{feedback}', [FeedbackController::class,'update'])->name('feedback.update');
Route::delete('feedback/{feedback}', [FeedbackController::class,'destroy'])->name('feedback.destroy');

Route::post('/vote/{id}', [VoteController::class, 'store'])->name('vote.store');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
