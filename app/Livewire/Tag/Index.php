<?php

namespace App\Livewire\Tag;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Tag;

class Index extends Component
{
    public $tags;
    public $name;

    public function mount()
    {
        $this->refreshTags();
    }

    public function refreshTags()
    {
        $this->tags = auth()->user()->tags()->get();
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:20',
            ];
    }

    protected function payload(): array
    {
        return [
            'user_id' => auth()->id(),
            'name'   => $this->name,
        ];
    }

    public function save()
    {
        $this->validate();

        try {
            $tag = Tag::create($this->payload());

            $this->refreshTags();

            $this->reset('name');

            session()->flash('success', '作成しました');

        } catch (\Throwable $e) {
            logger($e);

            session()->flash('error', '保存に失敗しました');
        }
    }

    public function render()
    {
        return view('livewire.tag.index')
            ->layout('components.layouts.base');
    }
}
