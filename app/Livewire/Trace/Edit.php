<?php

namespace App\Livewire\Trace;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Trace;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public Trace $trace;
    public string $title;
    public ?string $summary;
    public string $content;
    public string $status;

    public function mount(Trace $trace)
    {
        $this->trace = $trace;
        $this->title = $trace->title;
        $this->summary = $trace->summary;
        $this->content = $trace->content;
        $this->status = $trace->status;
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
            $this->trace->update($this->payload());

            session()->flash('success', "{$this->trace->title} を更新しました");
            return $this->redirectRoute('trace.show', $this->trace,  navigate: true);

        } catch (\Throwable $e) {
            logger($e);

            session()->flash('error', '保存に失敗しました');
        }
    }

    public function render()
    {
        return view('livewire.trace.edit')
            ->layout('components.layouts.base');
    }
}
