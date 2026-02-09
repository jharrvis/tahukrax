<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Paket Booth',
                'slug' => 'paket-booth',
                'price' => 4500000,
                'image_url' => 'assets/img/packages/Paket Booth_Tahu Krax.jpg',
                'description' => 'Paket lengkap dengan booth modern, peralatan masak lengkap, dan bahan baku awal.',
                'features' => [
                    'Booth Portable Premium',
                    'Peralatan Masak Lengkap',
                    'Bahan Baku Awal 100 Porsi',
                    'Seragam & Media Promosi',
                    'Training & SOP',
                ],
                'is_featured' => true,
            ],
            [
                'name' => 'Paket Hemat',
                'slug' => 'paket-hemat',
                'price' => 3500000,
                'image_url' => 'assets/img/packages/Paket Hemat_Tahu Krax.jpg',
                'description' => 'Solusi ekonomis untuk memulai usaha Tahu Krax dengan modal terjangkau.',
                'features' => [
                    'Booth Portable Standard',
                    'Peralatan Masak Dasar',
                    'Bahan Baku Awal 50 Porsi',
                    'X-Banner Promosi',
                    'Training Video',
                ],
                'is_featured' => false,
            ],
            [
                'name' => 'Paket Kontainer',
                'slug' => 'paket-kontainer',
                'price' => 15000000,
                'image_url' => 'assets/img/packages/Paket Kontainer_Tahu Krax.jpg',
                'description' => 'Outlet konsep kontainer mini yang eye-catching dan kokoh untuk lokasi outdoor.',
                'features' => [
                    'Booth Kontainer Minimalis',
                    'Peralatan Masak Heavy Duty',
                    'Bahan Baku Awal 300 Porsi',
                    'Neon Box & Branding Full',
                    'Seragam SPG/SPB',
                    'Training Langsung',
                ],
                'is_featured' => true,
            ],
            [
                'name' => 'Paket Signature',
                'slug' => 'paket-signature',
                'price' => 8500000,
                'image_url' => 'assets/img/packages/Paket Signature_Tahu Krax.jpg',
                'description' => 'Paket eksklusif dengan desain booth premium dan kelengkapan maksimal.',
                'features' => [
                    'Booth Signature Design',
                    'Deep Fryer Gas',
                    'Bahan Baku Awal 200 Porsi',
                    'Media Promosi Lengkap',
                    'Free Royalti Selamanya',
                ],
                'is_featured' => false,
            ],
            [
                'name' => 'Paket Tanpa Booth',
                'slug' => 'paket-tanpa-booth',
                'price' => 2500000,
                'image_url' => 'assets/img/packages/Paket Tanpa Booth_Tahu Krax.jpg',
                'description' => 'Pilihan tepat bagi yang sudah memiliki tempat atau booth sendiri.',
                'features' => [
                    'Lisensi Kemitraan',
                    'Bahan Baku Awal',
                    'Peralatan Masak (Opsional)',
                    'Media Branding Digital',
                ],
                'is_featured' => false,
            ],
            [
                'name' => 'Paket Ultimate',
                'slug' => 'paket-ultimate',
                'price' => 12000000,
                'image_url' => 'assets/img/packages/Paket Ultimate_Tahu Krax.jpg',
                'description' => 'Paket all-in-one dengan booth besar dan peralatan standar resto.',
                'features' => [
                    'Booth Ultimate Size',
                    'Deep Fryer Double Tank',
                    'Showcase Pemanas',
                    'Bahan Baku Awal 500 Porsi',
                    'Tablet POS Kasir',
                ],
                'is_featured' => true,
            ],
        ];

        foreach ($packages as $pkg) {
            Package::updateOrCreate(
                ['slug' => $pkg['slug']],
                $pkg
            );
        }
    }
}
