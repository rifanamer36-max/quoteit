<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuoteController;

Route::get('/', [QuoteController::class, 'index'])->name('quotes.index');
Route::post('/quotes', [QuoteController::class, 'store'])
    ->middleware('auth')
    ->name('quotes.store');
Route::patch('/quotes/{quote}', [QuoteController::class, 'update'])
    ->middleware('auth')
    ->name('quotes.update');

Route::delete('/quotes/{quote}', [QuoteController::class, 'destroy'])
    ->middleware('auth')
    ->name('quotes.destroy');
Route::get('/dashboard', function () {
    return redirect()->route('quotes.index');
})->middleware('auth')->name('dashboard');
Route::post('/quotes/{quote}/like', [QuoteController::class, 'like'])
    ->middleware('auth')
    ->name('quotes.like');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
    Route::post('/quotes/{quote}/save', [QuoteController::class, 'save'])->name('quotes.save');
    Route::get('/my-insights', [QuoteController::class, 'saved'])->name('quotes.saved');
});

require __DIR__.'/auth.php';