<?php

namespace App\Livewire\Trace;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Trace;
use App\Enums\TraceStatus;
use App\Enums\TraceRelationType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;

class Show extends Component
{
    use AuthorizesRequests;

    public Trace $trace;
    public bool $showAddRelationModal = false;
    public ?TraceRelationType $relationType = null;

    public function mount(Trace $trace): void
    {
        $this->authorize('view', $trace);
        $this->trace = $trace;
    }

    #[Computed]
    public function prerequisiteTraces(): Collection
    {
        return $this->trace->prerequisiteTraces();
    }

    #[Computed]
    public function childTraces(): Collection
    {
        return $this->trace->childTraces();
    }

    #[Computed]
    public function relatedTraces(): Collection
    {
        return $this->trace->relatedTraces();
    }

    #[Computed]
    public function availableRelationTraces(): Collection
    {
        return $this->trace->availableRelationTraces();
    }

    /**
     * Relation Operator
     */
    public function addRelation(Trace $selectedTrace): void
    {
        $this->trace->addRelation($selectedTrace, $this->relationType);

        $this->closeAddRelationModal();
    }

    public function removeRelation(Trace $relatedTrace): void
    {
        $this->trace->removeRelation($relatedTrace);
    }

    /**
     * Add Relation Modal Operator
     */
    public function openAddRelationModal(string $relationType): void
    {
        $this->relationType = TraceRelationType::from($relationType);
        $this->showAddRelationModal = true;
    }

    public function closeAddRelationModal(): void
    {
        $this->showAddRelationModal = false;
        $this->relationType = null;
    }

    /**
     * Trace Delete
     */
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
