<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShippingRate;
use Illuminate\Support\Facades\DB;

class ShippingRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path to the CSV file
        $csvFile = base_path('plan/pricelist/ongkir indah cargo.csv');

        // Check if file exists
        if (!file_exists($csvFile)) {
            $this->command->error("CSV file not found at: $csvFile");
            return;
        }

        $this->command->info("Seeding shipping rates from CSV...");

        // Open the file
        $file = fopen($csvFile, 'r');

        // Skip header row
        fgetcsv($file, 0, ';');

        $count = 0;
        $batchSize = 100;
        $data = [];

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($file, 0, ';')) !== false) {
                // Ensure row has enough columns (at least up to TUJUAN at index 8)
                if (count($row) < 9)
                    continue;

                $destinationCity = trim($row[8]); // TUJUAN
                $price = $this->parsePrice($row[5]); // HARGA INDAH ONLINE
                $minWeight = $this->parseMinWeight($row[12] ?? '>10'); // VARIAN

                if (empty($destinationCity) || $price <= 0)
                    continue;

                // Use updateOrCreate logic or just prepare for mass insert (if empty table)
                // For safety regarding duplicates, we will use updateOrCreate
                ShippingRate::updateOrCreate(
                    ['destination_city' => $destinationCity],
                    [
                        'price_per_kg' => $price,
                        'minimum_weight' => $minWeight
                    ]
                );

                $count++;
                if ($count % $batchSize == 0) {
                    $this->command->info("Processed $count records...");
                }
            }

            DB::commit();
            $this->command->info("Shipping rates seeded successfully! Total: $count");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Error seeding data: " . $e->getMessage());
        } finally {
            fclose($file);
        }
    }

    private function parsePrice($priceStr)
    {
        // Remove non-numeric characters except dots (if any, though usually just digits)
        // CSV shows "13332", no dots. But just in case.
        return (float) preg_replace('/[^0-9.]/', '', $priceStr);
    }

    private function parseMinWeight($weightStr)
    {
        // Extract number from string like ">10"
        if (preg_match('/(\d+)/', $weightStr, $matches)) {
            return (float) $matches[1];
        }
        return 10; // Default fallback
    }
}
