<?php

namespace App\Livewire\Admin\Product;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Addon;

use Livewire\WithFileUploads;

class AddonForm extends Component
{
    use WithFileUploads;

    public $addonId = null;

    // Form Properties
    public $name = '';
    public $type = 'unit'; // Default type
    public $price = 0;
    public $weight_kg = 0;
    public $description = '';
    public $image_url = ''; // Existing URL
    public $image; // Temporary upload

    public function mount($addon = null)
    {
        if ($addon) {
            // Handle both ID and Model instance
            if ($addon instanceof Addon) {
                $addonModel = $addon;
            } else {
                $addonModel = Addon::find($addon);
            }

            if ($addonModel && $addonModel->exists) {
                $this->addonId = $addonModel->id;
                $this->name = $addonModel->name;
                $this->type = $addonModel->type ?? 'unit';
                $this->price = (float) $addonModel->price;
                $this->weight_kg = (float) $addonModel->weight_kg;
                $this->description = $addonModel->description ?? '';
                $this->image_url = $addonModel->image_url ?? '';
            }
        }
    }

    #[Layout('layouts.dashboard')]
    #[Title('Form Add-on')]
    public function render()
    {
        return view('livewire.admin.product.addon-form');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'type' => 'required',
            'price' => 'required|numeric|min:0',
            'weight_kg' => 'required|numeric|min:0',
            'description' => 'nullable',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        // Handle Image Upload
        if ($this->image) {
            $path = $this->image->store('products/addons', 'public');
            $this->image_url = '/storage/' . $path;
        }

        // Find or create addon
        $addon = $this->addonId ? Addon::find($this->addonId) : new Addon();

        $addon->fill([
            'name' => $this->name,
            'type' => $this->type,
            'price' => $this->price,
            'weight_kg' => $this->weight_kg,
            'description' => $this->description,
            'image_url' => $this->image_url,
        ]);

        $addon->save();

        session()->flash('message', 'Add-on berhasil disimpan.');
        return redirect()->route('admin.addons.index');
    }
}
