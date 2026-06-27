<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SandboxController;
use App\Livewire\Trace\Index as TraceIndex;
use App\Livewire\Trace\Create as TraceCreate;
use App\Livewire\Trace\Show as TraceShow;
use App\Livewire\Trace\Edit as TraceEdit;
use App\Livewire\Tag\Index as TagIndex;

Route::view('/', 'top')->name('home');
Route::get('sandbox', SandboxController::class)->name('sandbox');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('traces', TraceIndex::class)->name('trace.index');
    Route::get('traces/create', TraceCreate::class)->name('trace.create');
    Route::get('traces/{trace}', TraceShow::class)->name('trace.show');
    Route::get('traces/{trace}/edit', TraceEdit::class)->name('trace.edit');

    Route::get('tags', TagIndex::class)->name('tag.index');
});

require __DIR__.'/settings.php';
