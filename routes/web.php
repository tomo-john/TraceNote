<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Trace\Index;
use App\Livewire\Trace\Create;

Route::view('/', 'top')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('traces/index', Index::class)->name('trace.index');
    Route::get('traces/create', Create::class)->name('trace.create');
});

require __DIR__.'/settings.php';
