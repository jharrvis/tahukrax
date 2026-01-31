<?php

namespace App\Livewire\Admin\Setting;

use App\Models\ShippingRate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\WithFileUploads;

class ShippingRateIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $csvFile;
    public $isImporting = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleImport()
    {
        $this->isImporting = !$this->isImporting;
    }

    public function import()
    {
        $this->validate([
            'csvFile' => 'required|file|mimes:csv,txt|max:2048', // 2MB Max
        ]);

        $path = $this->csvFile->getRealPath();
        $file = fopen($path, 'r');

        // Skip header
        fgetcsv($file, 0, ';');

        $count = 0;

        while (($row = fgetcsv($file, 0, ';')) !== false) {
            // Ensure row has enough columns (at least up to TUJUAN at index 8)
            if (count($row) < 9)
                continue;

            $destinationCity = trim($row[8]); // TUJUAN
            $price = $this->parsePrice($row[5]); // HARGA INDAH ONLINE
            $minWeight = $this->parseMinWeight($row[12] ?? '>10'); // VARIAN

            if (empty($destinationCity) || $price <= 0)
                continue;

            ShippingRate::updateOrCreate(
                ['destination_city' => $destinationCity],
                [
                    'price_per_kg' => $price,
                    'minimum_weight' => $minWeight
                ]
            );

            $count++;
        }

        fclose($file);

        $this->csvFile = null;
        $this->isImporting = false;
        session()->flash('message', "Sukses mengimport $count data ongkir.");
    }

    private function parsePrice($priceStr)
    {
        return (float) preg_replace('/[^0-9.]/', '', $priceStr);
    }

    private function parseMinWeight($weightStr)
    {
        if (preg_match('/(\d+)/', $weightStr, $matches)) {
            return (float) $matches[1];
        }
        return 10;
    }

    public function delete($id)
    {
        $rate = ShippingRate::find($id);
        if ($rate) {
            $rate->delete();
            session()->flash('message', 'Ongkos kirim berhasil dihapus.');
        }
    }

    #[Layout('layouts.dashboard')]
    #[Title('Manajemen Ongkos Kirim')]
    public function render()
    {
        $rates = ShippingRate::query()
            ->when($this->search, function ($query) {
                $query->where('destination_city', 'like', '%' . $this->search . '%');
            })
            ->orderBy('destination_city', 'asc')
            ->paginate(15);

        return view('livewire.admin.setting.shipping-rate-index', [
            'rates' => $rates
        ]);
    }
}
