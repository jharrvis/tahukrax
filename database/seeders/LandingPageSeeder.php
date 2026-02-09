<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Package;
use App\Models\Addon;
use App\Models\LandingPageContent;
use App\Models\ShippingRate;
use Illuminate\Support\Str;

class LandingPageSeeder extends Seeder
{
    public function run(): void
    {
        // Content
        $contents = [
            'site_title' => ['type' => 'text', 'content' => ['value' => 'TahuKrax | Peluang Usaha Tahu Crispy']],
            'hero_badge' => ['type' => 'text', 'content' => ['value' => 'PELUANG USAHA KEKINIAN']],
            'hero_title' => ['type' => 'text', 'content' => ['value' => 'Renyah, Gurih, <br class="hidden md:block"> <span class="text-warning">Untung Melimpah!</span>']],
            'hero_desc' => ['type' => 'text', 'content' => ['value' => 'Bukan sekadar jualan tahu, ini adalah "Mesin Uang" yang sudah kami siapkan kuncinya.']],
        ];

        foreach ($contents as $key => $data) {
            LandingPageContent::updateOrCreate(['key' => $key], $data);
        }

        // Packages
        $packages = [
            [
                'name' => 'Paket Tanpa Booth',
                'slug' => 'paket-tanpa-booth',
                'price' => 1900000,
                'weight_kg' => 10,
                'features' => ['Bahan Baku Awal', 'Peralatan Masak Dasar', 'Video Training'],
                'description' => 'Cocok untuk jualan di rumah atau booth sendiri.',
            ],
            [
                'name' => 'Paket Hemat',
                'slug' => 'paket-hemat',
                'price' => 2999000,
                'weight_kg' => 25,
                'features' => ['Booth Portable', 'Bahan Baku Awal', 'Peralatan Masak Lengkap', 'Banner Promosi'],
                'description' => 'Booth portable yang mudah dibawa-bawa. Best Seller!',
            ],
            [
                'name' => 'Paket Signature',
                'slug' => 'paket-signature',
                'price' => 4900000,
                'weight_kg' => 40,
                'features' => ['Booth Premium', 'Bahan Baku Banyak', 'Full Equipment', 'Seragam Crew'],
                'description' => 'Tampilan lebih premium & elegan.',
            ],
            [
                'name' => 'Paket Booth',
                'slug' => 'paket-booth',
                'price' => 5400000,
                'weight_kg' => 50,
                'features' => ['Booth Standard', 'Equipment Standard', 'Bahan Baku'],
                'description' => 'Pilihan standar untuk memulai usaha.',
            ],
            [
                'name' => 'Paket Ultimate',
                'slug' => 'paket-ultimate',
                'price' => 6900000,
                'weight_kg' => 60,
                'features' => ['Booth Ultimate', 'Equipment Lengkap', 'Bahan Baku Extra', 'Marketing Support'],
                'description' => 'Paket lengkap untuk hasil maksimal.',
            ],
            [
                'name' => 'Paket Kontainer',
                'slug' => 'paket-kontainer',
                'price' => 7500000,
                'weight_kg' => 100,
                'features' => ['Booth Kontainer', 'Full Equipment Pro', 'Bahan Baku Jumbo', 'Premium Support'],
                'description' => 'Outlet semi-permanen dengan tampilan mencolok.',
            ],
        ];

        foreach ($packages as $pkg) {
            Package::updateOrCreate(['slug' => $pkg['slug']], $pkg);
        }

        // Addons
        $addons = [
            ['name' => 'Tepung Bumbu Rahasia (1kg)', 'price' => 25000, 'stock' => 100, 'weight_kg' => 1, 'type' => 'bahan_baku'],
            ['name' => 'Kemasan Paper Bag (100pcs)', 'price' => 45000, 'stock' => 50, 'weight_kg' => 0.5, 'type' => 'packaging'],
            ['name' => 'Minyak Goreng Padat (15kg)', 'price' => 350000, 'stock' => 20, 'weight_kg' => 15, 'type' => 'bahan_baku'],
        ];

        foreach ($addons as $addon) {
            Addon::updateOrCreate(['name' => $addon['name']], $addon);
        }

        // Shipping Rates (Sample)
        $rates = [
            ['destination_city' => 'Jakarta', 'price_per_kg' => 10000, 'minimum_weight' => 5],
            ['destination_city' => 'Surabaya', 'price_per_kg' => 15000, 'minimum_weight' => 5],
            ['destination_city' => 'Bandung', 'price_per_kg' => 12000, 'minimum_weight' => 5],
            ['destination_city' => 'Medan', 'price_per_kg' => 35000, 'minimum_weight' => 5],
            ['destination_city' => 'Makassar', 'price_per_kg' => 40000, 'minimum_weight' => 5],
        ];

        foreach ($rates as $rate) {
            ShippingRate::updateOrCreate(['destination_city' => $rate['destination_city']], $rate);
        }
    }
}
