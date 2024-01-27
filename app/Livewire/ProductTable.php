<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Collection;
use Livewire\Component;

class ProductTable extends Component
{
    public string $search = '';

    public Collection $products;

    public function mount()
    {
        $this->products = Product::limit(50)->get();
    }

    public function updated($name, $value)
    {
        $this->products = Product::where('name', 'LIKE', '%'. $value . '%')->limit(50)->get();
    }

    public function render()
    {
        return view('livewire.product-table');
    }
}
