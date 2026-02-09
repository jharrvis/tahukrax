<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Dashboard extends Component
{
    #[Layout('layouts.dashboard')]
    #[Title('Admin Dashboard - TahuKrax')]
    public function render()
    {
        $stats = [
            'total_mitra' => \App\Models\User::where('role', 'mitra')->count(),
            'paket_terjual' => \App\Models\Order::where('status', 'paid')->count(),
            'pendapatan' => \App\Models\Order::where('status', 'paid')->sum('total_amount'),
            'laporan_masalah' => \App\Models\OrderConfirmation::where('condition', '!=', 'good')->count()
        ];

        $recentPartnerships = \App\Models\Partnership::with(['user', 'package'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recentPartnerships' => $recentPartnerships
        ]);
    }
}
