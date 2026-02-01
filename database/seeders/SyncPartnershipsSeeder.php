<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\Partnership;
use App\Models\OrderItem;

class SyncPartnershipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // Find valid package order (either direct package_id or in orderItems)
            $order = Order::where('user_id', $user->id)
                ->where(function ($q) {
                    $q->whereNotNull('package_id')
                        ->orWhereHas('orderItems', function ($qi) {
                            $qi->where('item_type', 'package');
                        });
                })
                ->latest()
                ->first();

            if ($order) {
                // Check if partnership exists
                $partnership = Partnership::where('user_id', $user->id)->first();

                if (!$partnership) {
                    // Determine Package ID
                    $packageId = $order->package_id;
                    if (!$packageId) {
                        $packageItem = $order->orderItems()->where('item_type', 'package')->first();
                        $packageId = $packageItem ? $packageItem->package_id : null;
                    }

                    if ($packageId) {
                        $status = ($order->status === 'paid' || $order->status === 'completed') ? 'active' : 'pending';

                        // Parse address from note if feasible, otherwise use blanks
                        // Note format: "Pengiriman ke KOTA, PROV. Kode Pos: 123. CP: 081. Alamat: Jl..."
                        $city = '-';
                        $province = '-';
                        $address = '-';
                        $postalCode = '-';
                        $phone = $user->phone_number ?? '-';

                        if (preg_match('/Pengiriman ke (.*?), (.*?)\./', $order->note, $m)) {
                            $city = trim($m[1]);
                            $province = trim($m[2]);
                        }
                        if (preg_match('/Alamat: (.*)/', $order->note, $m)) {
                            $address = trim($m[1]);
                        }
                        if (preg_match('/Kode Pos: (.*?)\./', $order->note, $m)) {
                            $postalCode = trim($m[1]);
                        }

                        // Create Partnership
                        $newPartnership = Partnership::create([
                            'user_id' => $user->id,
                            'package_id' => $packageId,
                            'partnership_code' => 'MTR-' . strtoupper(uniqid()),
                            'outlet_name' => 'Mitra ' . $user->name,
                            'recipient_name' => $user->name,
                            'phone_number' => $phone,
                            'address' => $address,
                            'city' => $city,
                            'province' => $province,
                            'postal_code' => $postalCode,
                            'joined_at' => $order->created_at,
                            'status' => $status,
                        ]);

                        // Link order to partnership
                        $order->update(['partnership_id' => $newPartnership->id]);

                        $this->command->info("Created Partnership for User: {$user->name}");
                    }
                } else {
                    // Ensure order is linked
                    if (!$order->partnership_id) {
                        $order->update(['partnership_id' => $partnership->id]);
                        $this->command->info("Linked Order #{$order->id} to existing Partnership.");
                    }
                }
            }
        }
    }
}
