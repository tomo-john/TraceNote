<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
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

    public function save()
    {
        $this->user->update([
            'name' => $this->name,
        ]);
    }

    public function render()
    {
        return view('livewire.user.profile')
            ->layout('components.layouts.base');
    }
}
