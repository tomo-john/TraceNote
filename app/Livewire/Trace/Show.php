<?php

namespace App\Livewire\Trace;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Trace;

class Show extends Component
{
    public Trace $trace;

    public function mount(Trace $trace)
    {
        $this->trace = $trace;
    }

    public function delete()
    {
        $this->trace->delete();

        session()->flash('success', '削除しました');
        return $this->redirectRoute('trace.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.trace.show')
            ->layout('components.layouts.base');
    }
}
