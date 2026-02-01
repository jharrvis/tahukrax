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

    public $trackingData = null;
    public $isLoadingTracking = false;

    public function checkResi()
    {
        $trackingNumber = $this->order->tracking_number;

        if (!$trackingNumber) {
            $this->dispatch('notify', ['message' => 'Nomor resi belum tersedia.', 'type' => 'error']);
            return;
        }

        $this->isLoadingTracking = true;
        $this->trackingData = null;

        try {
            $url = "https://www.indahonline.com/services/view?NO_RESI=" . $trackingNumber;
            $response = \Illuminate\Support\Facades\Http::get($url);

            if ($response->successful()) {
                $html = $response->body();
                $data = [];

                // Helper to extract values inside <strong> tags after a label
                $extract = function ($label, $content) {
                    if (preg_match('/' . preg_quote($label, '/') . '\s*:\s*<strong>(.*?)<\/strong>/is', $content, $m)) {
                        return trim(strip_tags($m[1]));
                    }
                    return null;
                };

                $data['tanggal'] = $extract('Tanggal Resi', $html);
                $data['no_resi'] = $extract('No Resi', $html);
                $data['pengirim'] = $extract('Nama Pengirim', $html);
                $data['penerima'] = $extract('Nama Penerima', $html);
                $data['asal'] = $extract('Asal', $html);
                $data['tujuan'] = $extract('Tujuan', $html);
                $data['layanan'] = $extract('Jasa Pengiriman', $html);
                $data['status'] = 'On Process';

                if ($data['no_resi']) {
                    $this->trackingData = $data;
                    $this->dispatch('open-tracking-modal');
                } else {
                    $this->dispatch('notify', ['message' => 'Data resi tidak ditemukan.', 'type' => 'warning']);
                    $this->dispatch('open-tracking-modal', ['url' => $url]);
                }
            } else {
                $this->dispatch('notify', ['message' => 'Gagal mengambil data dari Indah Online.', 'type' => 'error']);
            }
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Terjadi kesalahan: ' . $e->getMessage(), 'type' => 'error']);
        }

        $this->isLoadingTracking = false;
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
