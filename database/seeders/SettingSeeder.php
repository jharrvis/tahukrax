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
            ['key' => 'site_name', 'value' => 'RC GO Invoice System'],
            ['key' => 'site_description', 'value' => 'Sistem Pemesanan dan Kemitraan RC GO Indonesia'],

            // Company / Invoice
            ['key' => 'company_name', 'value' => 'PT. RC GO Indonesia'],
            ['key' => 'company_address', 'value' => "Jl. RC Veteran No. 88\nBintaro, Jakarta Selatan\nIndonesia 12330"],
            ['key' => 'company_email', 'value' => 'finance@rcgo.id'],
            ['key' => 'company_phone', 'value' => '+62 812-3456-7890'],

            // Finance
            ['key' => 'bank_account_default', 'value' => "BCA 1234567890 a.n PT RC GO Indonesia"],
            ['key' => 'origin_city', 'value' => 'Jakarta Selatan'],

            // Social Media
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/rcgo.id'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/rcgo.id'],
            ['key' => 'social_tiktok', 'value' => 'https://tiktok.com/@rcgo.id'],

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
