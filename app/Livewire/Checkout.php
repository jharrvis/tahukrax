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
    public $selectedPackages = []; // Format: [['id' => 1, 'qty' => 1, 'slug' => '...']]
    public $allPackages;
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
        $this->allPackages = Package::all(); // Cache all packages for lookup

        // If package is provided via route, add it to selectedPackages
        if ($package && $package->exists) {
            $this->selectedPackages[] = [
                'id' => $package->id,
                'slug' => $package->slug,
                'qty' => 1,
                'price' => $package->price,
                'weight_kg' => $package->weight_kg,
                'name' => $package->name
            ];
        }
        // Otherwise, selectedPackages will be populated via setPackages/loadPackagesFromCart from JS

        $this->allAddons = Addon::all();
        $this->provinces = Province::orderBy('name')->get();

        if (Auth::check()) {
            $user = Auth::user();
            $this->name = $user->name;
            $this->email = $user->email;

            // Pre-fill Address from Profile
            if ($user->phone_number)
                $this->phone_number = $user->phone_number;
            if ($user->address)
                $this->address = $user->address;
            if ($user->postal_code)
                $this->postal_code = $user->postal_code;

            if ($user->province_id) {
                $this->province_id = $user->province_id;
                // Trigger city loading manually since updatedProvinceId won't fire on mount
                $this->cities = City::where('province_code', $this->province_id)->orderBy('name')->get();

                if ($user->city_id) {
                    $this->city_id = $user->city_id;
                }
            }
        }
    }

    // Called from JavaScript
    public function setPackages($packages)
    {
        // Re-verify against DB to prevent price tampering
        $verifiedPackages = [];
        foreach ($packages as $p) {
            $dbPackage = $this->allPackages->firstWhere('slug', $p['slug']);
            if ($dbPackage) {
                $verifiedPackages[] = [
                    'id' => $dbPackage->id,
                    'slug' => $dbPackage->slug,
                    'qty' => max(1, intval($p['qty'] ?? 1)),
                    'price' => $dbPackage->price,
                    'weight_kg' => $dbPackage->weight_kg,
                    'name' => $dbPackage->name
                ];
            }
        }
        $this->selectedPackages = $verifiedPackages;

        // Auto-refresh loading state in frontend handled by Livewire re-render
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

    // Legacy setQuantity - kept for interface support but doesn't do much now
    public function setQuantity($qty)
    {
    }

    public function getTotalProperty()
    {
        $packagePrice = 0;
        $totalWeight = 0;

        foreach ($this->selectedPackages as $pkg) {
            $packagePrice += $pkg['price'] * $pkg['qty'];
            $totalWeight += $pkg['weight_kg'] * $pkg['qty'];
        }

        // Addons total
        $addonTotal = 0;
        foreach ($this->selectedAddons as $id => $qty) {
            $addon = $this->allAddons->firstWhere('id', $id);
            if ($addon) {
                $addonTotal += $addon->price * $qty;
                $totalWeight += ($addon->weight_kg ?? 0) * $qty;
            }
        }

        // Calculate shipping based on city
        $shippingCost = 0;
        if ($this->city_id) {
            $city = City::where('code', $this->city_id)->first();
            if ($city) {
                // 1. Exact match
                $rate = ShippingRate::where('destination_city', $city->name)->first();

                // 2. Cleaned match (Remove prefixes)
                if (!$rate) {
                    $cleanName = str_replace(['KABUPATEN ', 'KOTA ', 'ADMINISTRASI '], '', strtoupper($city->name));
                    $cleanName = trim($cleanName);

                    // Search if destination_city matches cleaned name OR looks like it
                    $rate = ShippingRate::where('destination_city', $cleanName)
                        ->orWhere('destination_city', 'like', "%$cleanName%")
                        ->first();
                }

                // 3. Reverse Like (If CSV has "JAKARTA" but DB has "JAKARTA PUSAT", this might be tricky, usually sticking to specific is safer)
                // But for "JAKARTA" general entry in CSV row 181, it says "JAKARTA"
                if (!$rate && str_contains($city->name, 'JAKARTA')) {
                    $rate = ShippingRate::where('destination_city', 'JAKARTA')->first();
                }

                if ($rate) {
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
            'grand_total' => $packagePrice + $addonTotal + $shippingCost,
            'total_weight' => $totalWeight
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

        if (empty($this->selectedPackages)) {
            $this->addError('package', 'Pilih minimal satu paket.');
            return;
        }

        if (!Auth::check()) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|string|min:8';
        }

        $this->validate($rules);

        // Get province and city names
        $province = Province::where('code', $this->province_id)->first();
        $city = City::where('code', $this->city_id)->first();

        $cityName = $city ? $city->name : '-';
        $provinceName = $province ? $province->name : '-';

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
        $primaryPackage = $this->selectedPackages[0] ?? null;

        // 2b. Handle Partnership Creation (Check if exists first)
        $partnership = \App\Models\Partnership::where('user_id', $user->id)->first();
        if (!$partnership && $primaryPackage) {
            $partnership = \App\Models\Partnership::create([
                'user_id' => $user->id,
                'package_id' => $primaryPackage ? $primaryPackage['id'] : null,
                'partnership_code' => 'MTR-' . strtoupper(uniqid()),
                'outlet_name' => 'Mitra ' . $user->name, // Default outlet name
                'recipient_name' => $this->name ?: $user->name,
                'phone_number' => $this->phone_number,
                'address' => $this->address,
                'city' => $cityName,
                'province' => $provinceName,
                'postal_code' => $this->postal_code,
                'joined_at' => now(),
                'status' => 'pending', // Pending until payment
            ]);
        }

        // 3. Create Order
        $order = Order::create([
            'user_id' => $user->id,
            'partnership_id' => $partnership ? $partnership->id : null,
            'package_id' => $primaryPackage ? $primaryPackage['id'] : null, // Legacy/Primary support
            'total_amount' => $totals['grand_total'],
            'shipping_cost' => $totals['shipping'],
            'status' => 'pending',
            'note' => "Pengiriman ke {$cityName}, {$provinceName}. Kode Pos: {$this->postal_code}. CP: {$this->phone_number}. Alamat: {$this->address}",
        ]);

        // 4. Create Order Items (Packages)
        foreach ($this->selectedPackages as $pkg) {
            OrderItem::create([
                'order_id' => $order->id,
                'package_id' => $pkg['id'],
                'item_type' => 'package',
                'quantity' => $pkg['qty'],
                'price' => $pkg['price'],
            ]);
        }

        // 5. Create Order Items (Add-ons)
        foreach ($this->selectedAddons as $id => $qty) {
            $addon = $this->allAddons->firstWhere('id', $id);
            OrderItem::create([
                'order_id' => $order->id,
                'addon_id' => $id,
                'item_type' => 'addon',
                'quantity' => $qty,
                'price' => $addon->price,
            ]);
        }

        // 5. Xendit Invoice
        $xenditService = app(\App\Services\XenditService::class);
        $description = "Pembayaran Paket RCGO: " . count($this->selectedPackages) . " item";

        $invoice = $xenditService->createInvoice([
            'external_id' => 'ORDER-' . $order->id . '-' . time(),
            'amount' => $totals['grand_total'],
            'payer_email' => $user->email,
            'description' => $description,
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
