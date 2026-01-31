<?php

namespace App\Livewire\Admin\Partner;

use App\Models\Partnership;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class PartnerIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    #[Layout('layouts.dashboard')]
    #[Title('Manajemen Mitra')]
    public function render()
    {
        $partnerships = Partnership::with('user', 'package')
            ->when($this->search, function ($query) {
                $query->where('outlet_name', 'like', '%' . $this->search . '%')
                    ->orWhere('partnership_code', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.partner.partner-index', [
            'partnerships' => $partnerships
        ]);
    }

    public function getStatusColor($status)
    {
        return match ($status) {
            'active' => 'bg-green-100 text-green-800',
            'inactive' => 'bg-red-100 text-red-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-slate-100 text-slate-800',
        };
    }
}
