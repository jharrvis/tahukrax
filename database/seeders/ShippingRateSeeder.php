<?php

namespace Database\Seeders;

use App\Models\ShippingRate;
use Illuminate\Database\Seeder;

class ShippingRateSeeder extends Seeder
{
    public function run(): void
    {
        $rates = [
            ['destination_city' => 'KOTA JAKARTA PUSAT', 'price_per_kg' => 15000, 'minimum_weight' => 1],
            ['destination_city' => 'KOTA JAKARTA SELATAN', 'price_per_kg' => 15000, 'minimum_weight' => 1],
            ['destination_city' => 'KOTA JAKARTA TIMUR', 'price_per_kg' => 15000, 'minimum_weight' => 1],
            ['destination_city' => 'KOTA JAKARTA BARAT', 'price_per_kg' => 15000, 'minimum_weight' => 1],
            ['destination_city' => 'KOTA JAKARTA UTARA', 'price_per_kg' => 15000, 'minimum_weight' => 1],
            ['destination_city' => 'KABUPATEN BOGOR', 'price_per_kg' => 12000, 'minimum_weight' => 1],
            ['destination_city' => 'KOTA BANDUNG', 'price_per_kg' => 20000, 'minimum_weight' => 1],
            ['destination_city' => 'KOTA SURABAYA', 'price_per_kg' => 35000, 'minimum_weight' => 1],
            ['destination_city' => 'KOTA MEDAN', 'price_per_kg' => 55000, 'minimum_weight' => 1],
        ];

        foreach ($rates as $rate) {
            ShippingRate::updateOrCreate(['destination_city' => $rate['destination_city']], $rate);
        }
    }
}
