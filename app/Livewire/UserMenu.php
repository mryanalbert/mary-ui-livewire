<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserMenu extends Component
{
    public $user;

    public function mount()
    {
        $this->user = [
            'id' => session('id'),
            'name' => session('name'),
            'email' => session('email')
        ];
    }

    public function render()
    {
        return view('livewire.user-menu');
    }
}
