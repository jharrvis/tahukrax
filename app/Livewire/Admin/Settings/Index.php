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
#[Title('Pengaturan Website - RCGO')]
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
