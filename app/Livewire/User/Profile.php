<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
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
            'name'  => ['required', 'string', 'max:255'],

            'email'  => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user->id),
            ],
        ];
    }

    protected function payload(): array
    {
        return [
            'name'   => $this->name,
            'email'   => $this->email,
        ];
    }

    public function save(): void
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
