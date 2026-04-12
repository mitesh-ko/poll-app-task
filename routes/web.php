<?php

use App\Events\PollAnswerAdded;
use App\Http\Controllers\PollController;
use App\Models\Poll;
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

Route::get('demo-call', function () {
    $poll = Poll::where('slug', 'dicta-fuga-ut-ad-la')->firstOrFail();
    broadcast(new PollAnswerAdded($poll));
});

require __DIR__.'/settings.php';
