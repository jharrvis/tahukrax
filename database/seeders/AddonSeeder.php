<?php

namespace Database\Seeders;

use App\Models\Addon;
use Illuminate\Database\Seeder;

class AddonSeeder extends Seeder
{
    public function run(): void
    {
        $addons = [
            // Unit RC Tambahan
            [
                'name' => 'RC Drift',
                'type' => 'car',
                'price' => 300000,
                'stock' => 50,
                'weight_kg' => 1.5,
                'description' => 'Unit RC Drift Premium dengan handling presisi dan body skala 1:16. Cocok untuk arena indoor dengan permukaan halus. Termasuk remote control 2.4GHz dan baterai rechargeable.'
            ],
            [
                'name' => 'RC Off-road',
                'type' => 'car',
                'price' => 380000,
                'stock' => 50,
                'weight_kg' => 2.0,
                'description' => 'Unit RC Off-road 4WD tangguh untuk segala medan. Suspensi independen, ban karet anti slip. Ideal untuk area outdoor seperti taman, lapangan, dan pantai.'
            ],
            [
                'name' => 'RC Stunt',
                'type' => 'car',
                'price' => 400000,
                'stock' => 50,
                'weight_kg' => 1.8,
                'description' => 'Unit RC Stunt dengan kemampuan akrobatik 360°, bisa jalan terbalik dan berputar. Paling diminati anak-anak untuk atraksi seru dan menarik perhatian pengunjung.'
            ],
            [
                'name' => 'Excavator',
                'type' => 'car',
                'price' => 475000,
                'stock' => 30,
                'weight_kg' => 2.5,
                'description' => 'RC Excavator dengan fungsi beko realistis: lengan bergerak, bucket bisa mengangkat. Unik dan edukatif, menjadi favorit anak-anak yang suka alat berat.'
            ],
            [
                'name' => 'Dump Truck',
                'type' => 'car',
                'price' => 375000,
                'stock' => 30,
                'weight_kg' => 2.2,
                'description' => 'RC Dump Truck dengan bak yang bisa diangkat otomatis. Roda besar dan kokoh untuk bermain di area pasir atau tanah. Cocok untuk tema konstruksi.'
            ],
            [
                'name' => 'Bulldozer',
                'type' => 'car',
                'price' => 390000,
                'stock' => 30,
                'weight_kg' => 2.3,
                'description' => 'RC Bulldozer dengan blade depan yang bisa bergerak naik turun. Track/rantai realistis untuk traksi maksimal. Pelengkap sempurna untuk paket alat berat.'
            ],

            // Aksesoris & Sparepart
            [
                'name' => 'Cas Rakitan',
                'type' => 'accessory',
                'price' => 130000,
                'stock' => 100,
                'weight_kg' => 0.5,
                'description' => 'Charger rakitan custom untuk baterai RC. Bisa mengisi hingga 4 baterai sekaligus. Hemat waktu charging dan cocok untuk operasional rental yang sibuk.'
            ],
            [
                'name' => 'Upgrade Remot + Timer',
                'type' => 'accessory',
                'price' => 150000,
                'stock' => 80,
                'weight_kg' => 0.3,
                'description' => 'Upgrade remote dengan fitur timer digital. Otomatis mati setelah waktu rental habis (5/10/15 menit). Memudahkan manajemen sewa dan menghindari konflik dengan pelanggan.'
            ],
            [
                'name' => 'Baterai Rakitan 1450',
                'type' => 'accessory',
                'price' => 20000,
                'stock' => 200,
                'weight_kg' => 0.1,
                'description' => 'Baterai rakitan 1450mAh untuk RC Drift dan Stunt. Durasi pakai sekitar 15-20 menit per charge. Wajib punya cadangan untuk kelancaran operasional.'
            ],
            [
                'name' => 'Baterai Rakitan 18650',
                'type' => 'accessory',
                'price' => 25000,
                'stock' => 200,
                'weight_kg' => 0.15,
                'description' => 'Baterai rakitan 18650 kapasitas lebih besar untuk RC Off-road dan alat berat. Durasi pakai 20-30 menit. Lebih awet dan tahan lama.'
            ],

            // Perlengkapan Arena
            [
                'name' => 'Standing Banner',
                'type' => 'track',
                'price' => 35000,
                'stock' => 100,
                'weight_kg' => 0.5,
                'description' => 'Standing banner untuk branding usaha rental Anda. Ukuran A3, desain custom dengan logo RC GO. Menarik perhatian pengunjung dari kejauhan.'
            ],
            [
                'name' => 'Banner Arena Drift 2m x 3m',
                'type' => 'track',
                'price' => 150000,
                'stock' => 50,
                'weight_kg' => 1.0,
                'description' => 'Banner alas arena drift ukuran 2x3 meter dengan desain track printed. Permukaan licin optimal untuk drift. Mudah dilipat dan dibawa-bawa.'
            ],
            [
                'name' => 'Arena Pipa Kecil',
                'type' => 'track',
                'price' => 430000,
                'stock' => 20,
                'weight_kg' => 5.0,
                'description' => 'Arena pipa PVC ukuran kecil (2x2 meter). Modular dan bisa dibongkar pasang. Cocok untuk area terbatas seperti mall atau ruko.'
            ],
            [
                'name' => 'Arena Pipa Besar',
                'type' => 'track',
                'price' => 1700000,
                'stock' => 10,
                'weight_kg' => 15.0,
                'description' => 'Arena pipa PVC ukuran besar premium (4x4 meter). Desain profesional dengan belokan dan terowongan. Menjadi daya tarik utama untuk event besar.'
            ],
            [
                'name' => 'Obstacle/Rintangan @1pcs',
                'type' => 'track',
                'price' => 150000,
                'stock' => 100,
                'weight_kg' => 1.0,
                'description' => 'Obstacle/rintangan satuan untuk arena off-road. Berbagai bentuk: tanjakan, jembatan, terowongan. Menambah tantangan dan keseruan bermain.'
            ],
        ];

        foreach ($addons as $addon) {
            Addon::updateOrCreate(
                ['name' => $addon['name']],
                $addon
            );
        }
    }
}
