<?php

namespace App\Livewire\Admin\Order;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class OrderDetail extends Component
{
    public Order $order;
    public $status;
    public $tracking_number;

    public function mount(Order $order)
    {
        $this->order = $order->load(['user', 'package', 'orderItems.addon', 'partnership']);
        $this->status = $order->status;
        $this->tracking_number = $order->tracking_number;
    }

    public function updateStatus()
    {
        $this->validate([
            'status' => 'required|in:pending,paid,shipped,completed,cancelled',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $this->order->update([
            'status' => $this->status,
            'tracking_number' => $this->tracking_number,
        ]);

        session()->flash('message', 'Status pesanan berhasil diperbarui.');
    }

    #[Layout('layouts.dashboard')]
    #[Title('Detail Pesanan')]
    public function render()
    {
        return view('livewire.admin.order.order-detail');
    }

    public function getStatusColor($status)
    {
        return match ($status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-blue-100 text-blue-800',
            'shipped' => 'bg-purple-100 text-purple-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-slate-100 text-slate-800',
        };
    }
}
