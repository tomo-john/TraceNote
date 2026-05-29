<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Trace\Index;
use App\Livewire\Trace\Create;
use App\Livewire\Trace\Show;
use App\Livewire\Trace\Edit;

Route::view('/', 'top')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('traces/index', Index::class)->name('trace.index');
    Route::get('traces/create', Create::class)->name('trace.create');
    Route::get('traces/{trace}', Show::class)->name('trace.show');
    Route::get('traces/{trace}/edit', Edit::class)->name('trace.edit');
});

require __DIR__.'/settings.php';
