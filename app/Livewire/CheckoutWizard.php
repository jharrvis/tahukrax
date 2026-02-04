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
use Livewire\Attributes\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CheckoutWizard extends Component
{
    // Wizard State
    #[Session]
    public int $step = 2; // Start from Step 2 (Step 1 is selection on LP)

    // Data State (Persisted in Session)
    #[Session]
    public $selectedPackages = []; // Format: [['id' => 1, 'qty' => 1, 'slug' => '...', ...]]
    #[Session]
    public $selectedAddons = []; // Format: [addon_id => qty]

    // Form Fields (Step 3)
    #[Session]
    public $name = '';
    #[Session]
    public $email = '';
    #[Session]
    public $phone_number = '';
    public $password = ''; // Don't persist password in session for security, but might need it if validation fails? No, better ask again.
    // Actually standard practice is to bind it, but if page refreshes, it's gone. That's fine.
    #[Session]
    public $province_id = '';
    #[Session]
    public $city_id = '';
    #[Session]
    public $postal_code = '';
    #[Session]
    public $address = '';

    // Reference Data (Not Persisted)
    public $allPackages;
    public $allAddons;
    public $provinces = [];
    public $cities = [];

    protected $listeners = ['packagesUpdated' => 'updatePackages'];

    public function mount(?Package $package = null)
    {
        $this->allPackages = Package::all();
        $this->allAddons = Addon::all();
        $this->provinces = Province::orderBy('name')->get();

        // If a package is passed directly via URL and no packages selected yet, select it
        if ($package && $package->exists && empty($this->selectedPackages)) {
            $this->addPackage($package);
        }

        if (Auth::check()) {
            $user = Auth::user();
            if (empty($this->name))
                $this->name = $user->name;
            if (empty($this->email))
                $this->email = $user->email;
            if (empty($this->phone_number) && $user->phone_number)
                $this->phone_number = $user->phone_number;
            if (empty($this->address) && $user->address)
                $this->address = $user->address;
            if (empty($this->postal_code) && $user->postal_code)
                $this->postal_code = $user->postal_code;
            if (empty($this->province_id) && $user->province_id)
                $this->province_id = $user->province_id;

            // Allow city to load automatically if province is set
            if ($this->province_id) {
                $this->cities = City::where('province_code', $this->province_id)->orderBy('name')->get();
                if (empty($this->city_id) && $user->city_id) {
                    $this->city_id = $user->city_id;
                }
            }
        }

        // Restore cities if province is selected (compulsory for re-hydration)
        if ($this->province_id && empty($this->cities)) {
            $this->cities = City::where('province_code', $this->province_id)->orderBy('name')->get();
        }
    }

    // --- Actions: Packages ---

    public function addPackage(Package $package)
    {
        // Check if already in list
        $index = $this->findPackageIndex($package->id);

        if ($index !== false) {
            $this->selectedPackages[$index]['qty']++;
        } else {
            $this->selectedPackages[] = [
                'id' => $package->id,
                'slug' => $package->slug,
                'qty' => 1,
                'price' => $package->price,
                'weight_kg' => $package->weight_kg,
                'name' => $package->name,
                'image' => $package->image // Ideally populate if available or use placeholder
            ];
        }
    }

    public function findPackageIndex($id)
    {
        foreach ($this->selectedPackages as $key => $pkg) {
            if ($pkg['id'] == $id)
                return $key;
        }
        return false;
    }

    public function incrementPackage($index)
    {
        $this->selectedPackages[$index]['qty']++;
    }

    public function decrementPackage($index)
    {
        if ($this->selectedPackages[$index]['qty'] > 1) {
            $this->selectedPackages[$index]['qty']--;
        } else {
            unset($this->selectedPackages[$index]);
            $this->selectedPackages = array_values($this->selectedPackages); // Reindex
        }
    }

    public function removePackage($index)
    {
        unset($this->selectedPackages[$index]);
        $this->selectedPackages = array_values($this->selectedPackages); // Reindex
    }

    // --- Actions: Addons ---

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
        } else {
            $this->selectedAddons[$addonId] = 1;
        }
        $this->dispatch('addons-changed', addons: $this->selectedAddons);
    }

    public function decrementAddon($addonId)
    {
        if (isset($this->selectedAddons[$addonId])) {
            if ($this->selectedAddons[$addonId] > 1) {
                $this->selectedAddons[$addonId]--;
            } else {
                unset($this->selectedAddons[$addonId]);
            }
        }
        $this->dispatch('addons-changed', addons: $this->selectedAddons);
    }

    public function removeAddon($addonId)
    {
        unset($this->selectedAddons[$addonId]);
        $this->dispatch('addons-changed', addons: $this->selectedAddons);
    }

    public function resetCart()
    {
        $this->selectedPackages = [];
        $this->selectedAddons = [];
        $this->dispatch('cart-reset');
    }

    // --- Shipping Logic ---

    public function updatedProvinceId($value)
    {
        $this->city_id = '';
        $this->cities = [];
        if ($value) {
            $this->cities = City::where('province_code', $value)->orderBy('name')->get();
        }
    }

    // --- Computed Properties ---

    public function getTotalProperty()
    {
        $packagePrice = 0;
        $totalWeight = 0;

        foreach ($this->selectedPackages as $pkg) {
            $packagePrice += $pkg['price'] * $pkg['qty'];
            $totalWeight += $pkg['weight_kg'] * $pkg['qty'];
        }

        // Addons
        $addonTotal = 0;
        if ($this->allAddons) { // Guard if allAddons not set yet
            foreach ($this->selectedAddons as $id => $qty) {
                $addon = $this->allAddons->firstWhere('id', $id);
                if ($addon) {
                    $addonTotal += $addon->price * $qty;
                    $totalWeight += ($addon->weight_kg ?? 0) * $qty;
                }
            }
        }

        // Shipping
        $shippingCost = 0;
        if ($this->city_id) {
            $city = City::where('code', $this->city_id)->first();
            if ($city) {
                // Same logic as Checkout.php
                $rate = ShippingRate::where('destination_city', $city->name)->first();
                if (!$rate) {
                    $cleanName = str_replace(['KABUPATEN ', 'KOTA ', 'ADMINISTRASI '], '', strtoupper($city->name));
                    $cleanName = trim($cleanName);
                    $rate = ShippingRate::where('destination_city', $cleanName)
                        ->orWhere('destination_city', 'like', "%$cleanName%")
                        ->first();
                }
                if (!$rate && str_contains($city->name, 'JAKARTA')) {
                    $rate = ShippingRate::where('destination_city', 'JAKARTA')->first();
                }

                if ($rate) {
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

    // --- Navigation & Validation ---

    public function nextStep()
    {
        if ($this->step === 2) {
            if (empty($this->selectedPackages)) {
                $this->addError('packages', 'Pilih minimal satu paket usaha untuk melanjutkan.');
                return;
            }
            $this->step = 3;
        } elseif ($this->step === 3) {
            $this->validateStep3();
            $this->step = 4;
        }
    }

    public function previousStep()
    {
        if ($this->step > 2) {
            $this->step--;
        }
    }

    public function goToStep($step)
    {
        if ($step < $this->step) {
            $this->step = $step;
        }
        // Only allow going forward if validation passes (simplified for now: restrict forward jump via UI)
    }

    public function validateStep3()
    {
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
    }

    public function processPayment()
    {
        // Final sanity check
        if (empty($this->selectedPackages)) {
            $this->addError('packages', 'Keranjang kosong.');
            return;
        }

        // Re-validate Step 3 in case of tampering
        $this->validateStep3();

        // --- Logic copied from Checkout.php submit() ---

        $province = Province::where('code', $this->province_id)->first();
        $city = City::where('code', $this->city_id)->first();
        $cityName = $city ? $city->name : '-';
        $provinceName = $province ? $province->name : '-';

        $isNewUser = false;
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
            $isNewUser = true;
        }

        $totals = $this->total;
        $primaryPackage = $this->selectedPackages[0] ?? null;

        // Partnership
        $partnership = \App\Models\Partnership::where('user_id', $user->id)->first();
        if (!$partnership && $primaryPackage) {
            $partnership = \App\Models\Partnership::create([
                'user_id' => $user->id,
                'package_id' => $primaryPackage ? $primaryPackage['id'] : null,
                'partnership_code' => 'MTR-' . strtoupper(uniqid()),
                'outlet_name' => 'Mitra ' . $user->name,
                'recipient_name' => $this->name ?: $user->name,
                'phone_number' => $this->phone_number,
                'address' => $this->address,
                'city' => $cityName,
                'province' => $provinceName,
                'postal_code' => $this->postal_code,
                'joined_at' => now(),
                'status' => 'pending',
            ]);
        }

        // Order
        $order = Order::create([
            'user_id' => $user->id,
            'partnership_id' => $partnership ? $partnership->id : null,
            'package_id' => $primaryPackage ? $primaryPackage['id'] : null,
            'total_amount' => $totals['grand_total'],
            'shipping_cost' => $totals['shipping'],
            'status' => 'pending',
            'note' => "Pengiriman ke {$cityName}, {$provinceName}. Kode Pos: {$this->postal_code}. CP: {$this->phone_number}. Alamat: {$this->address}",
        ]);

        // Order Items - Packages
        foreach ($this->selectedPackages as $pkg) {
            OrderItem::create([
                'order_id' => $order->id,
                'package_id' => $pkg['id'],
                'item_type' => 'package',
                'quantity' => $pkg['qty'],
                'price' => $pkg['price'],
            ]);
        }

        // Order Items - Addons
        if ($this->allAddons) {
            foreach ($this->selectedAddons as $id => $qty) {
                $addon = $this->allAddons->firstWhere('id', $id);
                if ($addon) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'addon_id' => $id,
                        'item_type' => 'addon',
                        'quantity' => $qty,
                        'price' => $addon->price,
                    ]);
                }
            }
        }

        // Xendit
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

            try {
                if ($isNewUser) {
                    \Illuminate\Support\Facades\Mail::to($user)->send(new \App\Mail\UserRegistered($user));
                }
                \Illuminate\Support\Facades\Mail::to($user)->send(new \App\Mail\OrderPlaced($order, $invoice['invoice_url']));
            } catch (\Exception $e) {
                Log::error('Failed to send checkout emails: ' . $e->getMessage());
            }

            // Clear session data
            $this->reset(['selectedPackages', 'selectedAddons', 'step']);

            return redirect($invoice['invoice_url']);
        }

        return redirect()->route('order.success', $order->id);
    }

    // JS Helper to load packages from localStorage if session is empty
    public function setPackages($packages)
    {
        if (empty($this->selectedPackages)) {
            // Re-verify against DB to prevent price tampering
            $verifiedPackages = [];
            foreach ($packages as $p) {
                $dbPackage = $this->allPackages->firstWhere('slug', $p['slug']);
                if ($dbPackage) {
                    $index = count($verifiedPackages);
                    $verifiedPackages[] = [
                        'id' => $dbPackage->id,
                        'slug' => $dbPackage->slug,
                        'qty' => max(1, intval($p['qty'] ?? 1)),
                        'price' => $dbPackage->price,
                        'weight_kg' => $dbPackage->weight_kg,
                        'name' => $dbPackage->name,
                        'image' => $dbPackage->image
                    ];
                }
            }
            $this->selectedPackages = $verifiedPackages;
        }
    }

    public function loadAddonsFromCart($addons)
    {
        if (empty($this->selectedAddons) && is_array($addons)) {
            $this->selectedAddons = $addons;
        }
    }

    public function render()
    {
        return view('livewire.checkout-wizard')
            ->layout('layouts.checkout');
    }
}
