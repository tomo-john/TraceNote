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

    public string $search = '';
    public string $status = '';

    #[Computed]
    public function traces()
    {
        return auth()->user()
                ->traces()
                ->when(
                    $this->search,
                    fn ($query) =>
                        $query->where('title', 'like', "%{$this->search}%")
                              ->orwhere('summary', 'like', "%{$this->search}%")
                )
                ->when(
                    $this->status,
                    fn ($query) =>
                        $query->where('status', $this->status)
                )
                ->latest()
                ->paginate(6);
    }

    public function render()
    {
        return view('livewire.trace.index')
            ->layout('components.layouts.base');
    }
}
