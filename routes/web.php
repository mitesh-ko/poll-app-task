<?php

use App\Http\Controllers\PollController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});

Route::get('poll/{slug}', [PollController::class, 'show'])->name('poll.show');
Route::post('poll/{slug}', [PollController::class, 'store'])->name('poll.store');

require __DIR__.'/settings.php';
