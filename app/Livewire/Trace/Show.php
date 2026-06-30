<?php

namespace App\Livewire\Trace;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Trace;
use App\Enums\TraceStatus;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Show extends Component
{
    use AuthorizesRequests;

    public Trace $trace;

    public function mount(Trace $trace): void
    {
        $this->authorize('view', $trace);
        $this->trace = $trace;
    }

    #[Computed]
    public function prerequisiteTraces()
    {
        return $this->trace->prerequisiteTraces();
    }

    #[Computed]
    public function childTraces()
    {
        return $this->trace->childTraces();
    }

    #[Computed]
    public function relatedTraces()
    {
        return $this->trace->relatedTraces();
    }

    #[Computed]
    public function availableRelationTraces()
    {
        return $this->trace->availableRelationTraces();
    }

    public function delete()
    {
        $this->authorize('delete', $this->trace);
        $this->trace->delete();

        session()->flash(
            'toast',
            [
                'message' => "削除しました",
                'type' => 'danger',
            ]
        );

        return $this->redirectRoute('trace.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.trace.show')
            ->layout('components.layouts.base');
    }
}
