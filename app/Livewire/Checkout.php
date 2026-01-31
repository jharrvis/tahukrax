<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\Addon;
use App\Models\ShippingRate;
use App\Models\Order;
use App\Models\OrderItem;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Checkout extends Component
{
    public ?Package $package = null;
    public $packageSlug = null;
    public $packageQty = 1; // Default 1
    public $allAddons;
    public $selectedAddons = [];

    // Form fields
    public $name = '';
    public $email = '';
    public $phone_number = '';
    public $password = '';
    public $province_id = '';
    public $city_id = '';
    public $postal_code = '';
    public $address = '';

    // Location data
    public $provinces = [];
    public $cities = [];

    protected $messages = [
        'name.required' => 'Nama lengkap wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.unique' => 'Email sudah terdaftar.',
        'phone_number.required' => 'Nomor WhatsApp wajib diisi.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 8 karakter.',
        'province_id.required' => 'Provinsi wajib dipilih.',
        'city_id.required' => 'Kota/Kabupaten wajib dipilih.',
        'postal_code.required' => 'Kode pos wajib diisi.',
        'address.required' => 'Alamat lengkap wajib diisi.',
    ];

    public function mount(?Package $package = null)
    {
        // If package is provided via route, use it
        if ($package && $package->exists) {
            $this->package = $package;
            $this->packageSlug = $package->slug;
        }
        // Otherwise, packageSlug will be set via JavaScript from localStorage

        $this->allAddons = Addon::all();
        $this->provinces = Province::orderBy('name')->get();

        if (Auth::check()) {
            $user = Auth::user();
            $this->name = $user->name;
            $this->email = $user->email;
        }
    }

    // Called from JavaScript when loading package from localStorage
    public function loadPackageBySlug($slug)
    {
        $package = Package::where('slug', $slug)->first();
        if ($package) {
            $this->package = $package;
            $this->packageSlug = $slug;
        }
    }

    // Load addons from localStorage cart
    public function loadAddonsFromCart($addons)
    {
        if (is_array($addons)) {
            $this->selectedAddons = $addons;
        }
    }

    public function updatedProvinceId($value)
    {
        $this->city_id = '';
        $this->cities = [];

        if ($value) {
            $this->cities = City::where('province_code', $value)->orderBy('name')->get();
        }
    }

    public function toggleAddon($addonId)
    {
        if (isset($this->selectedAddons[$addonId])) {
            unset($this->selectedAddons[$addonId]);
        } else {
            $this->selectedAddons[$addonId] = 1;
        }
        $this->dispatch('addons-changed', addons: $this->selectedAddons);
    }

    public function incrementAddon($addonId)
    {
        if (isset($this->selectedAddons[$addonId])) {
            $this->selectedAddons[$addonId]++;
        }
        $this->dispatch('addons-changed', addons: $this->selectedAddons);
    }

    public function decrementAddon($addonId)
    {
        if (isset($this->selectedAddons[$addonId]) && $this->selectedAddons[$addonId] > 1) {
            $this->selectedAddons[$addonId]--;
        } elseif (isset($this->selectedAddons[$addonId]) && $this->selectedAddons[$addonId] == 1) {
            unset($this->selectedAddons[$addonId]);
        }
        $this->dispatch('addons-changed', addons: $this->selectedAddons);
    }

    public function setQuantity($qty)
    {
        $this->packageQty = $qty;
    }

    public function getTotalProperty()
    {
        $packagePrice = ($this->package ? $this->package->price : 0) * $this->packageQty;
        // Addons total
        $addonTotal = 0;
        foreach ($this->selectedAddons as $id => $qty) {
            $addon = $this->allAddons->firstWhere('id', $id);
            if ($addon) {
                $addonTotal += $addon->price * $qty;
            }
        }

        // Calculate shipping based on city
        $shippingCost = 0;
        if ($this->city_id) {
            $city = City::where('code', $this->city_id)->first();
            if ($city) {
                // Try exact match first
                $rate = ShippingRate::where('destination_city', $city->name)->first();

                // Fallback: search for city name in destination_city (case-insensitive)
                if (!$rate) {
                    $rate = ShippingRate::where('destination_city', 'like', '%' . $city->name . '%')->first();
                }

                if ($rate) {
                    // Calculate total weight including package qty
                    $totalWeight = ($this->package ? $this->package->weight_kg : 1) * $this->packageQty;

                    foreach ($this->selectedAddons as $id => $qty) {
                        $addon = $this->allAddons->firstWhere('id', $id);
                        if ($addon) {
                            $totalWeight += ($addon->weight_kg ?? 0) * $qty;
                        }
                    }
                    // Minimum weight logic
                    $calcWeight = max($totalWeight, $rate->minimum_weight);
                    $shippingCost = $rate->price_per_kg * ceil($calcWeight);
                }
            }
        }

        return [
            'package' => $packagePrice,
            'addons' => $addonTotal,
            'shipping' => $shippingCost,
            'grand_total' => $packagePrice + $addonTotal + $shippingCost
        ];
    }

    public function submit()
    {
        // Custom validation based on auth status
        $rules = [
            'phone_number' => 'required|string|max:20',
            'province_id' => 'required',
            'city_id' => 'required',
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:500',
        ];

        if (!Auth::check()) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|string|min:8';
        }

        $this->validate($rules);

        // Get province and city names
        $province = Province::find($this->province_id);
        $city = City::find($this->city_id);

        // 1. Handle User Creation/Auth
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            $user = \App\Models\User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => 'mitra',
            ]);
            Auth::login($user);
        }

        // 2. Calculate Totals
        $totals = $this->total;

        // 3. Create Order
        $order = Order::create([
            'user_id' => $user->id,
            'package_id' => $this->package->id,
            'total_amount' => $totals['grand_total'],
            'shipping_cost' => $totals['shipping'],
            'status' => 'pending',
            'note' => "Pengiriman ke {$city->name}, {$province->name}. Kode Pos: {$this->postal_code}. CP: {$this->phone_number}. Alamat: {$this->address}",
        ]);

        // 4. Create Order Items (Add-ons)
        foreach ($this->selectedAddons as $id => $qty) {
            $addon = $this->allAddons->firstWhere('id', $id);
            OrderItem::create([
                'order_id' => $order->id,
                'addon_id' => $id,
                'quantity' => $qty,
                'price' => $addon->price,
            ]);
        }

        // 5. Xendit Invoice
        $xenditService = app(\App\Services\XenditService::class);
        $invoice = $xenditService->createInvoice([
            'external_id' => 'ORDER-' . $order->id . '-' . time(),
            'amount' => $totals['grand_total'],
            'payer_email' => $user->email,
            'description' => "Pembayaran Unit RCGO: " . $this->package->name,
            'order_id' => $order->id,
        ]);

        if ($invoice && isset($invoice['invoice_url'])) {
            $order->update(['xendit_invoice_id' => $invoice['id']]);
            return redirect($invoice['invoice_url']);
        }

        return redirect()->route('order.success', $order->id);
    }

    public function render()
    {
        return view('livewire.checkout')
            ->layout('layouts.checkout');
    }
}
