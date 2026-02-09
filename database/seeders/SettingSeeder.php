<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'TahuKrax Management System'],
            ['key' => 'site_description', 'value' => 'Sistem Kemitraan TahuKrax Indonesia'],

            // Company / Invoice
            ['key' => 'company_name', 'value' => 'TahuKrax Indonesia'],
            ['key' => 'company_address', 'value' => "Jl. TahuKrax No. 1\nJakarta, Indonesia"],
            ['key' => 'company_email', 'value' => 'info@tahukrax.com'],
            ['key' => 'company_phone', 'value' => '+62 812-3456-7890'],

            // Finance
            ['key' => 'bank_account_default', 'value' => "BCA 1234567890 a.n TahuKrax Indonesia"],
            ['key' => 'origin_city', 'value' => 'Jakarta Selatan'],

            // Social Media
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/tahukrax.id'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/tahukrax.id'],
            ['key' => 'social_tiktok', 'value' => 'https://tiktok.com/@tahukrax.id'],

            // App Config
            ['key' => 'invoice_footer_note', 'value' => 'Pembayaran ditransfer ke rekening di atas. Bukti transfer wajib dikirimkan ke Admin.'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
