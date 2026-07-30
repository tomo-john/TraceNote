<?php

namespace App\Livewire\Sandbox;

use Livewire\Component;

class Test extends Component
{
    public bool $showModal = false;

    public function openModal(): void
    {
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function render()
     {
         return view('livewire.sandbox.test')
            ->layout('components.layouts.base');
     }
}
