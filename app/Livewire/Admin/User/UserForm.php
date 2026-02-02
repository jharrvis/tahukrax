<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class UserForm extends Component
{
    public ?User $user = null;

    // Form Data
    public $name;
    public $email;
    public $password;
    public $role = 'mitra'; // Default role

    public function mount(User $user = null)
    {
        if ($user->exists) {
            $this->user = $user;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->role;
        }
    }

    public function save()
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($this->user?->id),
            'role' => 'required|in:admin,mitra',
        ];

        // Password validation: required for new users, optional for editing
        if (!$this->user || $this->password) {
            $rules['password'] = 'required|min:8';
        }

        $this->validate($rules);

        // Prepare data
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        // Hash password if provided
        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->user && $this->user->exists) {
            if ($this->user->id === auth()->id() && $this->role !== 'admin') {
                $this->dispatch('notify', message: 'Anda tidak bisa mengubah role akun sendiri.', type: 'error');
                return;
            }
            $this->user->update($data);
            $message = 'User berhasil diperbarui.';
        } else {
            User::create($data);
            $message = 'User baru berhasil dibuat.';
        }

        $this->dispatch('notify', message: $message, type: 'success');
        return redirect()->route('admin.users.index');
    }

    #[Layout('layouts.dashboard')]
    #[Title('Form Pengguna')]
    public function render()
    {
        return view('livewire.admin.user.user-form');
    }
}
