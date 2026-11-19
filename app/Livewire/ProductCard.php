<?php

namespace App\Livewire;

use Livewire\Component;

class ProductCard extends Component
{
    /** @var array<string, mixed> */
    public array $product = [];

    public function render()
    {
        return view('livewire.product-card');
    }
}
