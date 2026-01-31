<?php

namespace App\Livewire\Mitra;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Dashboard extends Component
{
    #[Layout('layouts.dashboard')]
    #[Title('Mitra Dashboard - RCGO')]
    public function render()
    {
        $userId = \Illuminate\Support\Facades\Auth::id();

        $stats = [
            'packages' => \App\Models\Partnership::where('user_id', $userId)->where('status', 'active')->count(),
            'orders' => \App\Models\Order::where('user_id', $userId)->count(),
            'spending' => \App\Models\Order::where('user_id', $userId)
                ->whereIn('status', ['paid', 'shipped', 'completed'])
                ->sum('total_amount'),
        ];

        return view('livewire.mitra.dashboard', ['stats' => $stats]);
    }
}
