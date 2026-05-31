<?php

namespace App\Livewire\Tag;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Tag;

class Index extends Component
{
    public $tags;

    public function mount()
    {
        $this->tags = auth()->user()->tags()->get();
    }

    public function render()
    {
        return view('livewire.tag.index')
            ->layout('components.layouts.base');
    }
}
