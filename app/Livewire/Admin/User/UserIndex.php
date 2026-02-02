<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete(User $user)
    {
        if ($user->id === auth()->id()) {
            $this->dispatch('notify', message: 'Anda tidak dapat menghapus akun sendiri.', type: 'error');
            return;
        }

        $user->delete();
        $this->dispatch('notify', message: 'User berhasil dihapus.', type: 'success');
    }

    #[Layout('layouts.dashboard')]
    #[Title('Daftar Pengguna')]
    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.user.user-index', [
            'users' => $users
        ]);
    }
}
