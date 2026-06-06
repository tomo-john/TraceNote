<?php

namespace App\Livewire\Tag;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Index extends Component
{
    use AuthorizesRequests;

    public $tags;
    public string $name = '';
    public string $color = 'gray';
    public bool $showCreateForm = false;
    public ?int $editingId = null;

    public function mount()
    {
        $this->refreshTags();
    }

    protected function refreshTags(): void
    {
        $this->tags = auth()->user()->tags()->get();
    }

    // Create関連
    public function openCreateForm(): void
    {
        $this->cancelEdit();
        $this->showCreateForm = true;
    }

    public function closeCreateForm(): void
    {
        $this->reset('name');
        $this->showCreateForm = false;
    }

    #[Computed]
    public function colorClasses(): array
    {
        return Tag::colorClasses();
    }

    #[Computed]
    public function previewClass(): string
    {
        return Tag::colorClasses()[$this->color];
    }

    // Edit関連
    public function edit(int $tagId): void
    {
        $this->closeCreateForm();

        $tag = Tag::findOrFail($tagId);

        $this->authorize('update', $tag);

        $this->editingId = $tag->id;

        $this->name = $tag->name;
    }

    public function cancelEdit(): void
    {
        $this->editingId = null;
        $this->reset('name');
        $this->color = 'gray';
    }

    // Delete関連
    public function delete(int $tagId): void
    {
        $tag = Tag::findOrFail($tagId);

        $this->authorize('delete', $tag);

        $tag->delete();

        $this->refreshTags();

        $this->cancelEdit();

        session()->flash('success', '削除しました');
    }

    // 保存処理関連
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:20',
            'color' => 'required|string',
            ];
    }

    protected function payload(): array
    {
        return [
            'user_id' => auth()->id(),
            'name'    => $this->name,
            'color'   => $this->color,
        ];
    }

    public function save(): void
    {
        $this->validate();

        try {
            if($this->editingId) {
                $tag = Tag::findOrFail($this->editingId);

                 $this->authorize('update', $tag);

                $tag->update($this->payload());

                $this->refreshTags();

                $this->cancelEdit();

                session()->flash('success', "{$tag->name} を更新しました");
            } else {
                $tag = Tag::create($this->payload());

                $this->closeCreateForm();

                $this->refreshTags();

                $this->cancelEdit();

                session()->flash('success', '作成しました');
            }

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
