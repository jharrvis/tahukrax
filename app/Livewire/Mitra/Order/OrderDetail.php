<?php

namespace App\Livewire\Mitra\Order;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class OrderDetail extends Component
{
    public Order $order;

    public function mount(Order $order)
    {
        // Security check: Ensure order belongs to logged-in user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        $this->order = $order;
    }

    #[Layout('layouts.dashboard')]
    #[Title('Detail Pesanan')]
    public function render()
    {
        return view('livewire.mitra.order.order-detail');
    }

    public function getStatusColor($status)
    {
        // Reusing same color logic, could be extracted to a trait or helper later
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
