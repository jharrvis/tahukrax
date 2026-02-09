<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class ForgotPassword extends Component
{
    public $email = '';
    public $status = null;

    protected $rules = [
        'email' => 'required|email',
    ];

    public function sendResetLink()
    {
        $this->validate();

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->status = __($status);
            $this->email = ''; // Clear email after success
        } else {
            $this->addError('email', __($status));
        }
    }

    #[Layout('layouts.auth')]
    #[Title('Lupa Password | TahuKrax')]
    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
