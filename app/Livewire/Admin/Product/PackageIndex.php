<?php

namespace App\Livewire\Admin\Product;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Package;

class PackageIndex extends Component
{
    use WithPagination;

    public $search = '';

    #[Layout('layouts.dashboard')]
    #[Title('Paket Usaha | TahuKrax Admin')]
    public function render()
    {
        $packages = Package::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.product.package-index', [
            'packages' => $packages
        ]);
    }

    public function delete($id)
    {
        Package::find($id)->delete();
        session()->flash('message', 'Paket berhasil dihapus.');
    }
}
