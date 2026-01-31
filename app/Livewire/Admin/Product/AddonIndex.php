<?php

namespace App\Livewire\Admin\Product;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Addon;

class AddonIndex extends Component
{
    use WithPagination;

    public $search = '';

    #[Layout('layouts.dashboard')]
    #[Title('Add-on Produk | RCGO Admin')]
    public function render()
    {
        $addons = Addon::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.product.addon-index', [
            'addons' => $addons
        ]);
    }

    public function delete($id)
    {
        Addon::find($id)->delete();
        session()->flash('message', 'Add-on berhasil dihapus.');
    }
}
