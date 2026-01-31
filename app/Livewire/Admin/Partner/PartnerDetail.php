<?php

namespace App\Livewire\Admin\Partner;

use App\Models\Partnership;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class PartnerDetail extends Component
{
    public Partnership $partnership;
    public $status;

    public function mount(Partnership $partnership)
    {
        $this->partnership = $partnership->load(['user', 'package', 'orders']);
        $this->status = $partnership->status;
    }

    public function updateStatus()
    {
        $this->validate([
            'status' => 'required|in:active,inactive,pending',
        ]);

        $this->partnership->update([
            'status' => $this->status,
        ]);

        session()->flash('message', 'Status mitra berhasil diperbarui.');
    }

    #[Layout('layouts.dashboard')]
    #[Title('Detail Mitra')]
    public function render()
    {
        return view('livewire.admin.partner.partner-detail');
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
