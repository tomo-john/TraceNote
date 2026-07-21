<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SandboxController;
use App\Livewire\Trace\Index as TraceIndex;
use App\Livewire\Trace\Create as TraceCreate;
use App\Livewire\Trace\Show as TraceShow;
use App\Livewire\Trace\Edit as TraceEdit;
use App\Livewire\Tag\Index as TagIndex;
use App\Livewire\User\Profile;
use App\Livewire\Sandbox\Test;

Route::view('/', 'top')->name('home');

Route::view('/test', 'dummy')->name('test');
Route::view('/about', 'dummy')->name('about');
Route::view('/privacy', 'dummy')->name('privacy');
Route::view('/contact', 'dummy')->name('contact');

Route::get('sandbox', SandboxController::class)->name('sandbox');
Route::get('sandbox/test', Test::class)->name('sandbox.test');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('traces', TraceIndex::class)->name('trace.index');
    Route::get('traces/create', TraceCreate::class)->name('trace.create');
    Route::get('traces/{trace}', TraceShow::class)->name('trace.show');
    Route::get('traces/{trace}/edit', TraceEdit::class)->name('trace.edit');

    Route::get('tags', TagIndex::class)->name('tag.index');

    Route::get('user/profile', Profile::class)->name('user.profile');
});

require __DIR__.'/settings.php';
