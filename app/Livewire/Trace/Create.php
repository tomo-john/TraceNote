<?php

namespace App\Livewire\Trace;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Trace;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public string $title;
    public ?string $summary;
    public string $content;
    public string $status = Trace::STATUS_DRAFT;
    public array $selectedTags = [];
    public $tags;

    public function mount()
    {
        $this->tags = auth()->user()->tags()->orderBy('name')->get();
    }

    protected function rules(): array
    {
        return [
            'title'   => 'required|string|max:255',
            'summary' => 'nullable|string|max:255',
            'content' => 'required|string',
            'status'  => [
                'required',
                'string',
                Rule::in(array_keys(Trace::statuses())),
            ],
        ];
    }

    protected function payload(): array
    {
        return [
            'user_id' => auth()->id(),
            'title'   => $this->title,
            'summary' => $this->summary,
            'content' => $this->content,
            'status'  => $this->status,
        ];
    }

    public function save()
    {
        $this->validate();

        try {
            $trace = Trace::create($this->payload());

            $trace->tags()->sync($this->selectedTags);

            session()->flash(
                'toast',
                [
                    'message' => "{$trace->title} を作成しました",
                    'type' => 'success',
                ]
            );

            return $this->redirectRoute('trace.index', navigate: true);

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
        return view('livewire.trace.create')
            ->layout('components.layouts.base');
    }
}
