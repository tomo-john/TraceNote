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
    public $tags;
    public ?int $selectedTagId = null;

    public function mount()
    {
        $this->tags = auth()->user()->tags()->get();
    }

    #[Computed]
    public function traces()
    {
        return auth()->user()
                ->traces()
                ->when(
                    $this->search,
                    fn ($query) =>
                        $query->where(function ($query) {
                            $query->where('title', 'like', "%{$this->search}%")
                                  ->orwhere('summary', 'like', "%{$this->search}%");
                        })
                )
                ->when(
                    $this->status,
                    fn ($query) =>
                        $query->where('status', $this->status)
                )
                ->when(
                    $this->selectedTagId,
                    fn ($query) =>
                        $query->whereHas(
                            'tags',
                            fn ($q) => $q->where('tags.id', $this->selectedTagId)
                        )
                )
                ->latest()
                ->paginate(6);
    }

    #[Computed]
    public function totalTraces()
    {
        return auth()->user()->traces()->count();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->status = '';
        $this->selectedTagId = null;
    }

    public function render()
    {
        return view('livewire.trace.index')
            ->layout('components.layouts.base');
    }
}
