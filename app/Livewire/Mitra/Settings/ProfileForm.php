<?php

namespace App\Livewire\Mitra\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Province;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProfileForm extends Component
{
    // Profile Data
    public $name;
    public $email;
    public $phone_number;

    // Address Data
    public $province_id;
    public $city_id;
    public $postal_code;
    public $address;

    // Password Data
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    // Select Data
    public $provinces = [];
    public $cities = [];

    public function mount()
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;

        $this->province_id = $user->province_id;
        $this->city_id = $user->city_id;
        $this->postal_code = $user->postal_code;
        $this->address = $user->address;

        $this->provinces = Province::orderBy('name')->get();

        if ($this->province_id) {
            $this->cities = City::where('province_code', $this->province_id)->orderBy('name')->get();
        }
    }

    public function updatedProvinceId($value)
    {
        $this->city_id = '';
        $this->cities = [];

        if ($value) {
            $this->cities = City::where('province_code', $value)->orderBy('name')->get();
        }
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone_number' => 'nullable|string|max:20',
            'province_id' => 'nullable',
            'city_id' => 'nullable',
            'postal_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
            'postal_code' => $this->postal_code,
            'address' => $this->address,
        ]);

        // session()->flash('message', 'Profil berhasil diperbarui.');
        $this->dispatch('notify', message: 'Profil berhasil diperbarui.', type: 'success');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        // session()->flash('password_message', 'Password berhasil diubah.');
        $this->dispatch('notify', message: 'Password berhasil diubah.', type: 'success');
    }

    #[Layout('layouts.dashboard')]
    #[Title('Pengaturan Akun')]
    public function render()
    {
        return view('livewire.mitra.settings.profile-form');
    }
}
