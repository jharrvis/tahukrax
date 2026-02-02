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
        $this->order = $order->load(['user', 'package', 'orderItems.addon', 'partnership', 'confirmation']);
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

        // Send Email Notifications
        try {
            if ($this->status === 'shipped') {
                \Illuminate\Support\Facades\Mail::to($this->order->user)->send(new \App\Mail\OrderShipped($this->order));
            } elseif ($this->status === 'completed') {
                \Illuminate\Support\Facades\Mail::to($this->order->user)->send(new \App\Mail\OrderDelivered($this->order));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send status update email: ' . $e->getMessage());
            $this->dispatch('notify', ['message' => 'Status update saved but email failed to send.', 'type' => 'warning']);
            // Return early or continue? Continue to flash message.
        }

        session()->flash('message', 'Status pesanan berhasil diperbarui.');
    }

    public $trackingData = null;
    public $isLoadingTracking = false;

    public function checkResi()
    {
        if (!$this->tracking_number) {
            $this->dispatch('notify', ['message' => 'Nomor resi belum diisi.', 'type' => 'error']);
            return;
        }

        $this->isLoadingTracking = true;
        $this->trackingData = null;

        try {
            $url = "https://www.indahonline.com/services/view?NO_RESI=" . $this->tracking_number;
            $response = \Illuminate\Support\Facades\Http::get($url);

            if ($response->successful()) {
                $html = $response->body();
                $data = [];

                // Simple regex parsing based on observed structure
                if (preg_match('/Tanggal Resi &nbsp;:&nbsp; <strong>(.*?)<\/strong>/s', $html, $m))
                    $data['tanggal'] = trim($m[1]); // Note: Markup might vary, using loose matching first
                // Trying simpler matching

                // Helper to extract values inside <strong> tags after a label
                $extract = function ($label, $content) {
                    // Match: Label : <strong>Value</strong>
                    // Note: The source has newlines and spaces. 
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
                $data['status'] = 'On Process'; // Indah's public view often hides status history?

                // Only set if we found at least something
                if ($data['no_resi']) {
                    $this->trackingData = $data;
                    $this->dispatch('open-tracking-modal'); // Re-open or update modal
                } else {
                    $this->dispatch('notify', ['message' => 'Data resi tidak ditemukan atau format berubah.', 'type' => 'warning']);
                    // Fallback: suggest opening link
                    $this->dispatch('open-tracking-modal', ['url' => $url]);
                }
            } else {
                $this->dispatch('notify', ['message' => 'Gagal mengambil data dari Indah Online.', 'type' => 'error']);
            }
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Terjadi kesalahan saat melacak: ' . $e->getMessage(), 'type' => 'error']);
        }

        $this->isLoadingTracking = false;
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
