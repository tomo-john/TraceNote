<?php

namespace App\Livewire\Trace;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Trace;

class Index extends Component
{
    public $traces;

    public function mount()
    {
        $this->traces = auth()->user()->traces()->with('tags')->get();
    }

    public function render()
    {
        return view('livewire.trace.index')
            ->layout('components.layouts.base');
    }
}
