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
            'site_title' => ['type' => 'text', 'content' => ['value' => 'RCGO | Paket Usaha Rental RC Offroad Extreme']],
            'hero_badge' => ['type' => 'text', 'content' => ['value' => 'BISNIS ANTI-MAINSTREAM']],
            'hero_title' => ['type' => 'text', 'content' => ['value' => 'TRAJANG <br class="hidden md:block"> <span class="text-warning">LUMPUR</span> CUAN!']],
            'hero_desc' => ['type' => 'text', 'content' => ['value' => 'Bangun kerajaan rental mobil RC Offroad. Kami sediakan unit "Badak" dan strategi bisnis paling gahar!']],
        ];

        foreach ($contents as $key => $data) {
            LandingPageContent::updateOrCreate(['key' => $key], $data);
        }

        // Packages
        $packages = [
            [
                'name' => 'SCOUT MISSION',
                'slug' => 'scout-mission',
                'price' => 5500000,
                'weight_kg' => 15,
                'features' => ['6 Unit RC Rock Crawler 4WD', '12 Baterai High-Torque', 'Banner "Waspada Cuan"'],
                'description' => 'Paket pemula untuk memulai bisnis di lokasi kecil.',
            ],
            [
                'name' => 'TANKER ELITE',
                'slug' => 'tanker-elite',
                'price' => 12500000,
                'weight_kg' => 35,
                'features' => ['12 Unit RC Monster Truck', 'Sirkuit Kayu Portable', 'Toolbox & Suku Cadang'],
                'description' => 'Paket paling populer untuk hasil maksimal.',
            ],
            [
                'name' => 'COMMANDER',
                'slug' => 'commander',
                'price' => 25000000,
                'weight_kg' => 80,
                'features' => ['25 Unit Mixed Arena', 'Full Arena Design Support', 'Branding Booth Besi Custom'],
                'description' => 'Paket lengkap untuk pengusaha serius.',
            ],
        ];

        foreach ($packages as $pkg) {
            Package::updateOrCreate(['slug' => $pkg['slug']], $pkg);
        }

        // Addons
        $addons = [
            ['name' => 'Baterai Cadangan 3000mAh', 'price' => 150000, 'stock' => 50, 'weight_kg' => 0.2, 'type' => 'sparepart'],
            ['name' => 'Ban Crawler Super Grip (Set)', 'price' => 350000, 'stock' => 20, 'weight_kg' => 0.5, 'type' => 'sparepart'],
            ['name' => 'Charger Fast-Charge 4-Slot', 'price' => 450000, 'stock' => 10, 'weight_kg' => 0.8, 'type' => 'equipment'],
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
