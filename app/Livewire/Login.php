<?php

namespace App\Livewire;

use App\Models\FederatedUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.empty')]
class Login extends Component
{
    #[Rule('required')]
    public $username = '';

    #[Rule('required')]
    public $password = '';

    public function save()
    {
        $validated = $this->validate();

        $user = FederatedUser::where('userName', $validated['username'])->first();

        if ($user) {
            if (Hash::check($validated['password'], $user->userPassword)) {
                Auth::login($user);

                session([
                    'id' => $user->userId,
                    'name' => $user->name,
                    'email' => $user->email,
                ]);

                return redirect()->route('dashboard');
            }
        }

        dd('Invalid credentials');
    }

    public function googleLogin()
    {
        redirect()->route('auth.google');
    }

    public function render()
    {
        return view('livewire.login');
    }
}
