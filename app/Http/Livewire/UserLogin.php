<?php

namespace App\Http\Livewire;

use session;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserLogin extends Component
{
    public $email, $password, $rememberMe;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function render()
    {
        return view('livewire.user-login');
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function login()
    {
       $credentials = $this->validate();

       if (Auth::guard('web')->attempt($credentials, $this->rememberMe)) {

        return redirect()->intended('/');
    }

    session()->flash('error', 'The provided credentials do not match our records.');
    
    }
}
