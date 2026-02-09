<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'mitra', // Default to mitra for customers
        ]);

        Auth::login($user);

        // Send Welcome Email
        try {
            \Illuminate\Support\Facades\Mail::to($user)->send(new \App\Mail\UserRegistered($user));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send welcome email: ' . $e->getMessage());
        }

        return redirect()->intended('/');
    }

    #[Layout('layouts.auth')]
    #[Title('Daftar Kemitraan | TahuKrax')]
    public function render()
    {
        return view('livewire.auth.register');
    }
}
