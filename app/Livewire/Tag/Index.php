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
    public bool $showForm = false;
    public ?int $editingId = null;

    public function mount()
    {
        $this->refreshTags();
    }

    protected function refreshTags(): void
    {
        $this->tags = auth()->user()->tags()->get();
    }

    // Form
    public function openForm(): void
    {
        $this->resetForm();

        $this->showForm = true;
    }

    public function closeForm(): void
    {
        $this->resetForm();
    }

    protected function resetForm(): void
    {
        $this->reset([
            'name',
            'editingId'
        ]);

        $this->color = 'gray';

        $this->showForm = false;

        $this->resetErrorBag();
    }

    // Color
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

    // Edit
    public function edit(int $tagId): void
    {
        $this->openForm();

        $tag = Tag::findOrFail($tagId);

        $this->authorize('update', $tag);

        $this->editingId = $tag->id;

        $this->name = $tag->name;
        $this->color = $tag->color;
    }

    // Delete
    public function delete(int $tagId): void
    {
        $tag = Tag::findOrFail($tagId);

        $this->authorize('delete', $tag);

        $tag->delete();

        $this->refreshTags();

        $this->closeForm();

        $this->dispatch(
            'notify',
            message: '削除しました',
            type: 'danger'
        );
    }

    // Save
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
            'name'    => $this->name,
            'color'   => $this->color,
        ];
    }

    public function save(): void
    {
        $this->validate();

        try {
            $isEditing = $this->editingId !== null;

            if ($isEditing) {
                $tag = Tag::findOrFail($this->editingId);
                $this->authorize('update', $tag);
            } else {
                $tag = new Tag();
                $tag->user_id = auth()->id();
            }

            $tag->fill($this->payload());

            $tag->save();

            $this->refreshTags();

            $this->closeForm();

            $this->dispatch(
                'notify',
                message: $isEditing
                    ? "{$tag->name} を更新しました"
                    : "{$tag->name} を作成しました",
                type: 'success'
            );
        } catch (\Throwable $e) {
            logger($e);

            $this->dispatch(
                'notify',
                message: '保存に失敗しました',
                type: 'danger'
            );
        }
    }

    public function render()
    {
        return view('livewire.tag.index')
            ->layout('components.layouts.base');
    }
}
