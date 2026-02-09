<?php

namespace Database\Seeders;

use App\Models\Addon;
use Illuminate\Database\Seeder;

class AddonSeeder extends Seeder
{
    public function run(): void
    {
        $addons = [
            // Booths
            ['name' => 'Booth Koper Mini', 'price' => 2250000, 'type' => 'booth', 'weight_kg' => 10, 'description' => 'Booth portable ukuran mini, mudah dibawa.'],
            ['name' => 'Booth Koper Reguler', 'price' => 3750000, 'type' => 'booth', 'weight_kg' => 15, 'description' => 'Booth portable ukuran reguler.'],
            ['name' => 'Booth Lipat Kayu', 'price' => 1500000, 'type' => 'booth', 'weight_kg' => 12, 'description' => 'Booth lipat bahan kayu estetik.'],
            ['name' => 'Booth Galvalum', 'price' => 3000000, 'type' => 'booth', 'weight_kg' => 20, 'description' => 'Booth bahan galvalum awet dan kokoh.'],
            ['name' => 'Booth Kontainer', 'price' => 5500000, 'type' => 'booth', 'weight_kg' => 50, 'description' => 'Booth style kontainer industrial.'],

            // Bahan Baku
            ['name' => 'Tepung Tahu Krax', 'price' => 103000, 'type' => 'material', 'weight_kg' => 1, 'description' => 'Tepung bumbu rahasia Tahu Krax.'],

            // Peralatan & Perlengkapan
            ['name' => 'Standing banner', 'price' => 35000, 'type' => 'equipment', 'weight_kg' => 1, 'description' => 'Banner promosi berdiri.'],
            ['name' => 'Kompor 1 tungku', 'price' => 500000, 'type' => 'equipment', 'weight_kg' => 3, 'description' => 'Kompor gas 1 tungku SNI.'],
            ['name' => 'Selang+regulator', 'price' => 250000, 'type' => 'equipment', 'weight_kg' => 1, 'description' => 'Selang gas dan regulator aman.'],
            ['name' => 'Kaos', 'price' => 150000, 'type' => 'merchandise', 'weight_kg' => 0.2, 'description' => 'Kaos seragam Tahu Krax.'],
            ['name' => 'Topi', 'price' => 75000, 'type' => 'merchandise', 'weight_kg' => 0.1, 'description' => 'Topi seragam Tahu Krax.'],
            ['name' => 'Celemek', 'price' => 65000, 'type' => 'merchandise', 'weight_kg' => 0.1, 'description' => 'Celemek/Apron masak.'],
            ['name' => 'Serok besar', 'price' => 60000, 'type' => 'equipment', 'weight_kg' => 0.5, 'description' => 'Serok penggorengan ukuran besar.'],
            ['name' => 'Serok kecil', 'price' => 40000, 'type' => 'equipment', 'weight_kg' => 0.3, 'description' => 'Serok penggorengan ukuran kecil.'],
            ['name' => 'Wajan', 'price' => 200000, 'type' => 'equipment', 'weight_kg' => 2, 'description' => 'Wajan penggorengan khusus.'],
            ['name' => 'Saringan minyak', 'price' => 50000, 'type' => 'equipment', 'weight_kg' => 0.2, 'description' => 'Saringan untuk meniriskan minyak.'],

            // Bumbu Tabur
            ['name' => 'BB Tabur Extra Hot', 'price' => 43400, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu tabur pedas level ekstra.'],
            ['name' => 'BB Tabur Lv 3', 'price' => 49100, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu tabur pedas level 3.'],
            ['name' => 'BB Tabur Lv 5', 'price' => 54200, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu tabur pedas level 5.'],
            ['name' => 'BB Tabur Lv 6', 'price' => 59500, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu tabur pedas level 6.'],
            ['name' => 'BB Tabur Lv 7', 'price' => 64700, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu tabur pedas level 7.'],
            ['name' => 'BB Tabur Keju', 'price' => 37800, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu tabur rasa keju.'],
            ['name' => 'BB Tabur Pizza', 'price' => 42800, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu tabur rasa pizza.'],
            ['name' => 'BB Tabur Sapi Panggang', 'price' => 37800, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu tabur rasa sapi panggang.'],
            ['name' => 'BB Tabur Balado', 'price' => 37800, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu tabur rasa balado.'],
            ['name' => 'BB Tabur BBQ', 'price' => 37800, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu tabur rasa BBQ.'],
            ['name' => 'BB Tabur Ikan Bakar', 'price' => 48500, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu tabur rasa ikan bakar.'],
            ['name' => 'BB Tabur Teriyaki', 'price' => 37800, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu tabur rasa teriyaki.'],
            ['name' => 'BB Tabur Jagung Mexiko', 'price' => 42800, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu tabur rasa jagung mexiko.'],
            ['name' => 'BB Tabur Rendang', 'price' => 43500, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu tabur rasa rendang.'],
            ['name' => 'BB Tabur Sambal Setan', 'price' => 75200, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu tabur sambal setan (sangat pedas).'],
            ['name' => 'BB Tabur Sambal Dewa', 'price' => 117000, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu tabur sambal dewa (premium).'],
            ['name' => 'BB Tabur Sambal Mercon', 'price' => 129000, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu tabur sambal mercon (eksplosif).'],
            ['name' => 'BB Tabur Basreng Original', 'price' => 49100, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu khusus Basreng original.'],
            ['name' => 'BB Tabur Basreng Lv 10', 'price' => 54200, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu khusus Basreng level 10.'],
            ['name' => 'BB Tabur Basreng Lv 15', 'price' => 64700, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu khusus Basreng level 15.'],

            // Bumbu Rendam & Lainnya
            ['name' => 'Bumbu Rendam', 'price' => 38000, 'type' => 'material', 'weight_kg' => 0.5, 'description' => 'Bumbu marinasi rendam.'],
            ['name' => 'Bungkus Reguler @100 pcs', 'price' => 32500, 'type' => 'packaging', 'weight_kg' => 0.5, 'description' => 'Kemasan bungkus reguler isi 100 pcs.'],
        ];

        foreach ($addons as $addon) {
            Addon::updateOrCreate(
                ['name' => $addon['name']],
                $addon
            );
        }
    }
}
