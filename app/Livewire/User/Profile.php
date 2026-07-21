<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\User;

class Profile extends Component
{
    public User $user;
    public string $name;
    public string $email;

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    protected function payload(): array
    {
        return [
            'name'   => $this->name,
        ];
    }

    public function save()
    {
        $this->validate();

        $this->user->update($this->payload());
    }

    public function render()
    {
        return view('livewire.user.profile')
            ->layout('components.layouts.base');
    }
}
