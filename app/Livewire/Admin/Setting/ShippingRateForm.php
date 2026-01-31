<?php

namespace App\Livewire\Admin\Setting;

use App\Models\ShippingRate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class ShippingRateForm extends Component
{
    public $rateId = null;
    public $destination_city = '';
    public $price_per_kg = 0;
    public $minimum_weight = 1;

    public function mount($rate = null)
    {
        if ($rate) {
            $rateModel = ShippingRate::find($rate);
            if ($rateModel) {
                $this->rateId = $rateModel->id;
                $this->destination_city = $rateModel->destination_city;
                $this->price_per_kg = (float) $rateModel->price_per_kg;
                $this->minimum_weight = (float) $rateModel->minimum_weight;
            }
        }
    }

    public function save()
    {
        $this->validate([
            'destination_city' => 'required|string|max:255',
            'price_per_kg' => 'required|numeric|min:0',
            'minimum_weight' => 'required|numeric|min:0.1',
        ]);

        $rate = $this->rateId ? ShippingRate::find($this->rateId) : new ShippingRate();

        $rate->fill([
            'destination_city' => $this->destination_city,
            'price_per_kg' => $this->price_per_kg,
            'minimum_weight' => $this->minimum_weight,
        ]);

        $rate->save();

        session()->flash('message', 'Ongkos kirim berhasil disimpan.');
        return redirect()->route('admin.settings.shipping.index');
    }

    #[Layout('layouts.dashboard')]
    #[Title('Form Ongkos Kirim')]
    public function render()
    {
        return view('livewire.admin.setting.shipping-rate-form');
    }
}
