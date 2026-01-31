<?php

namespace App\Livewire\Admin\Product;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Package;
use Illuminate\Support\Str;

use Livewire\WithFileUploads;

class PackageForm extends Component
{
    use WithFileUploads;

    public $packageId = null;

    // Form Properties
    public $name = '';
    public $price = 0;
    public $weight_kg = 0;
    public $features = ''; // List of features (newline separated)
    public $description = '';
    public $image_url = ''; // Existing URL
    public $image; // Temporary upload

    public function mount($package = null)
    {
        if ($package) {
            // Handle both ID and Model instance
            if ($package instanceof Package) {
                $packageModel = $package;
            } else {
                $packageModel = Package::find($package);
            }

            if ($packageModel && $packageModel->exists) {
                $this->packageId = $packageModel->id;
                $this->name = $packageModel->name;
                $this->price = (float) $packageModel->price;
                $this->weight_kg = (float) $packageModel->weight_kg;
                $this->description = $packageModel->description ?? '';
                $this->image_url = $packageModel->image_url ?? '';
                // Convert array to newline separated string for textarea
                $this->features = is_array($packageModel->features)
                    ? implode("\n", $packageModel->features)
                    : '';
            }
        }
    }

    #[Layout('layouts.dashboard')]
    #[Title('Form Paket Usaha')]
    public function render()
    {
        return view('livewire.admin.product.package-form');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric|min:0',
            'weight_kg' => 'required|numeric|min:0',
            'description' => 'nullable',
            'features' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        // Handle Image Upload
        if ($this->image) {
            $path = $this->image->store('products/packages', 'public');
            $this->image_url = '/storage/' . $path;
        }

        // Process features string to array
        $featuresArray = [];
        if (!empty($this->features)) {
            $featuresArray = array_filter(array_map('trim', explode("\n", $this->features)));
        }

        // Find or create package
        $package = $this->packageId ? Package::find($this->packageId) : new Package();

        $package->fill([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'price' => $this->price,
            'weight_kg' => $this->weight_kg,
            'description' => $this->description,
            'features' => $featuresArray,
            'image_url' => $this->image_url,
        ]);

        $package->save();

        session()->flash('message', 'Paket berhasil disimpan.');
        return redirect()->route('admin.packages.index');
    }
}
