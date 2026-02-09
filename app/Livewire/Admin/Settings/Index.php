<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.dashboard')]
#[Title('Pengaturan Website - TahuKrax')]
class Index extends Component
{

    use WithFileUploads;

    public $activeTab = 'general';

    // General
    public $site_name, $site_description, $site_logo;
    public $new_site_logo;

    // Company / Invoice
    public $company_name, $company_address, $company_email, $company_phone, $company_signature;
    public $new_company_signature;

    // Finance
    public $bank_account_default, $origin_city;

    // Social
    public $social_facebook, $social_instagram, $social_tiktok;

    // System & Email
    public $mail_mailer = 'smtp';
    public $mail_host, $mail_port, $mail_username, $mail_password, $mail_encryption, $mail_from_address, $mail_from_name;
    public $test_email_recipient;

    public function mount()
    {
        // Load all settings
        $settings = Setting::all()->pluck('value', 'key');

        $this->site_name = $settings['site_name'] ?? '';
        $this->site_description = $settings['site_description'] ?? '';
        $this->site_logo = $settings['site_logo'] ?? '';

        $this->company_name = $settings['company_name'] ?? '';
        $this->company_address = $settings['company_address'] ?? '';
        $this->company_email = $settings['company_email'] ?? '';
        $this->company_phone = $settings['company_phone'] ?? '';
        $this->company_signature = $settings['company_signature'] ?? '';

        $this->bank_account_default = $settings['bank_account_default'] ?? '';
        $this->origin_city = $settings['origin_city'] ?? '';

        $this->social_facebook = $settings['social_facebook'] ?? '';
        $this->social_instagram = $settings['social_instagram'] ?? '';
        $this->social_tiktok = $settings['social_tiktok'] ?? '';

        // Load Mail Settings from Config/.env
        $this->mail_mailer = config('mail.default', 'smtp');
        $this->mail_host = config('mail.mailers.smtp.host');
        $this->mail_port = config('mail.mailers.smtp.port');
        $this->mail_username = config('mail.mailers.smtp.username');
        $this->mail_password = config('mail.mailers.smtp.password'); // Be careful exposing this!
        $this->mail_encryption = config('mail.mailers.smtp.encryption');
        $this->mail_from_address = config('mail.from.address');
        $this->mail_from_name = config('mail.from.name');
    }

    // Helper to update .env
    protected function updateEnv($data = [])
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            $env = file_get_contents($path);

            foreach ($data as $key => $value) {
                // Wrap value in quotes if it contains spaces
                if (str_contains($value, ' ') && !str_starts_with($value, '"')) {
                    $value = '"' . $value . '"';
                }

                // If key exists, replace it
                if (preg_match("/^{$key}=.*/m", $env)) {
                    $env = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $env);
                } else {
                    // Append if not exists
                    $env .= "\n{$key}={$value}";
                }
            }

            file_put_contents($path, $env);
        }
    }

    public function sendTestEmail()
    {
        $this->validate(['test_email_recipient' => 'required|email']);

        try {
            // Force set config for this request just in case .env update hasn't propagated or using in-memory
            config([
                'mail.mailers.smtp.host' => $this->mail_host,
                'mail.mailers.smtp.port' => $this->mail_port,
                'mail.mailers.smtp.username' => $this->mail_username,
                'mail.mailers.smtp.password' => $this->mail_password,
                'mail.mailers.smtp.encryption' => $this->mail_encryption,
                'mail.from.address' => $this->mail_from_address,
                'mail.from.name' => $this->mail_from_name,
            ]);

            \Illuminate\Support\Facades\Mail::to($this->test_email_recipient)->send(new \App\Mail\TestEmail());

            $this->dispatch('notify', message: 'Test email berhasil dikirim!', type: 'success');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Gagal mengirim email: ' . $e->getMessage(), type: 'error');
        }
    }

    public function update($group)
    {
        $keys = [];

        if ($group === 'general') {
            $this->validate([
                'site_name' => 'required|string|max:255',
                'new_site_logo' => 'nullable|image|max:1024',
            ]);

            if ($this->new_site_logo) {
                // Delete old logo
                if ($this->site_logo)
                    Storage::delete($this->site_logo);
                $this->site_logo = $this->new_site_logo->store('settings', 'public');
            }

            $keys = ['site_name', 'site_description', 'site_logo'];
        } elseif ($group === 'company') {
            $this->validate([
                'company_name' => 'required|string',
                'new_company_signature' => 'nullable|image|max:1024',
            ]);

            if ($this->new_company_signature) {
                if ($this->company_signature)
                    Storage::delete($this->company_signature);
                $this->company_signature = $this->new_company_signature->store('settings', 'public');
            }

            $keys = ['company_name', 'company_address', 'company_email', 'company_phone', 'company_signature'];
        } elseif ($group === 'finance') {
            $keys = ['bank_account_default', 'origin_city'];
        } elseif ($group === 'social') {
            $keys = ['social_facebook', 'social_instagram', 'social_tiktok'];
        } elseif ($group === 'system') {
            // Update .env directly
            $this->updateEnv([
                'MAIL_MAILER' => $this->mail_mailer,
                'MAIL_HOST' => $this->mail_host,
                'MAIL_PORT' => $this->mail_port,
                'MAIL_USERNAME' => $this->mail_username,
                'MAIL_PASSWORD' => $this->mail_password,
                'MAIL_ENCRYPTION' => $this->mail_encryption,
                'MAIL_FROM_ADDRESS' => $this->mail_from_address,
                'MAIL_FROM_NAME' => $this->mail_from_name,
            ]);

            // Clear config cache
            \Illuminate\Support\Facades\Artisan::call('config:clear');

            $this->dispatch('notify', message: 'Konfigurasi Email berhasil disimpan! Mohon refresh halaman jika perlu.', type: 'success');
            return; // No DB update needed for .env settings
        }

        foreach ($keys as $key) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $this->$key]
            );
            // Clear cache
            Cache::forget("setting_{$key}");
        }

        $this->dispatch('notify', message: 'Pengaturan berhasil disimpan!', type: 'success');

        // Reset file inputs
        $this->new_site_logo = null;
        $this->new_company_signature = null;
    }

    public function render()
    {
        return view('livewire.admin.settings.index');
    }
}
