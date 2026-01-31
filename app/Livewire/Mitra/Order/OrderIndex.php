<?php

namespace App\Livewire\Mitra\Order;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class OrderIndex extends Component
{
    use WithPagination;

    public $filterStatus = '';

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    #[Layout('layouts.dashboard')]
    #[Title('Pesanan Saya')]
    public function render()
    {
        $orders = Order::where('user_id', Auth::id())
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.mitra.order.order-index', [
            'orders' => $orders
        ]);
    }

    public function getStatusColor($status)
    {
        return match ($status) {
            'paid' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'shipped' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-emerald-100 text-emerald-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-slate-100 text-slate-800',
        };
    }
}
