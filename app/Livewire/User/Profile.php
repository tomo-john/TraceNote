<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
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
    public string $password_confirmation = '';

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

    // ==== Payload ====
    protected function profilePayload(): array
    {
        return [
            'name'   => $this->name,
            'email'   => $this->email,
        ];
    }

    protected function passwordPayload(): array
    {
        return [
            'password' => Hash::make($this->password),
        ];
    }

    // ==== Actions ====
    public function saveProfile(): void
    {
        $this->validate($this->profileRules());

        $this->user->update($this->profilePayload());

        $this->dispatch(
            'notify',
            message: 'プロフィールを更新しました',
            type: 'success'
        );
    }

    public function savePassword(): void
    {
        $this->validate($this->passwordRules());

        $this->user->update($this->passwordPayload());

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch(
            'notify',
            message: 'パスワードを更新しました',
            type: 'success'
        );
    }

    // ==== Render ====
    public function render()
    {
        return view('livewire.user.profile')
            ->layout('components.layouts.base');
    }
}
