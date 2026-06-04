<?php

namespace App\Livewire\Trace;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Trace;


class Index extends Component
{
    use WithPagination;

    #[Computed]
    public function traces()
    {
        return auth()->user()->traces()->latest()->paginate(6);
    }

    public function render()
    {
        return view('livewire.trace.index')
            ->layout('components.layouts.base');
    }
}
