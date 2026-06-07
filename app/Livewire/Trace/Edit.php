<?php

namespace App\Livewire\Trace;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Trace;
use App\Enums\TraceStatus;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Edit extends Component
{
    use AuthorizesRequests;

    public Trace $trace;
    public string $title;
    public ?string $summary;
    public string $content;
    public string $status;
    public array   $statuses = [];
    public array $selectedTags = [];
    public $tags;

    public function mount(Trace $trace)
    {
        $this->authorize('update', $trace);

        $this->trace = $trace;
        $this->title = $trace->title;
        $this->summary = $trace->summary;
        $this->content = $trace->content;
        $this->status = $trace->status->value;
        $this->statuses = TraceStatus::options();

        $this->tags = auth()->user()->tags()->orderBy('name')->get();
        $this->selectedTags = $trace->tags->pluck('id')->toArray();
    }

    protected function rules(): array
    {
        return [
            'title'   => 'required|string|max:255',
            'summary' => 'nullable|string|max:255',
            'content' => 'required|string',
            'status'  => [
                'required',
                 new Enum(TraceStatus::class),
            ],
        ];
    }

    protected function payload(): array
    {
        return [
            'title'   => $this->title,
            'summary' => $this->summary,
            'content' => $this->content,
            'status'  => $this->status,
        ];
    }

    public function save()
    {
        $this->authorize('update', $this->trace);

        $this->validate();

        try {
            $this->trace->update($this->payload());

            $this->trace->tags()->sync($this->selectedTags);

            session()->flash(
                'toast',
                [
                    'message' => "{$this->trace->title} を更新しました",
                    'type' => 'success',
                ]
            );

            return $this->redirectRoute('trace.show', $this->trace,  navigate: true);

        } catch (\Throwable $e) {
            logger($e);

            session()->flash(
                'toast',
                [
                    'message' => "保存に失敗しました",
                    'type' => 'danger',
                ]
            );
        }
    }

    public function render()
    {
        return view('livewire.trace.edit')
            ->layout('components.layouts.base');
    }
}
