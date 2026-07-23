<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\User;

class Profile extends Component
{
    // ==== Properties ====
    public User $user;
    public string $name = '';
    public string $email = '';
    public string $current_password = '';
    public string $password = '';
    public string $password_confirm = '';

    // ==== Lifecycle ====
    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }

    // ==== Validation ====
    protected function profileRules(): array
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

    protected function passwordRules(): array
    {
        return [
            'current_password' => [
                'required',
                'current_password',
            ],

            'password' => [
                'required',
                Password::defaults(),
                'confirmed'
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

    // ==== Actions ====
    public function saveProfile(): void
    {
        $this->validate($this->profileRules());

        $this->user->update($this->payload());

        $this->dispatch(
            'notify',
            message: 'プロフィールを更新しました',
            type: 'success');
    }

    public function savePassword(): void
    {
    }

    // ==== Render ====
    public function render()
    {
        return view('livewire.user.profile')
            ->layout('components.layouts.base');
    }
}
