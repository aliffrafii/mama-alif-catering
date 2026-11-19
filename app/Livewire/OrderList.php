<?php

namespace App\Livewire;

use Livewire\Component;

class OrderList extends Component
{
    /** @var array<int, array<string, mixed>> */
    public array $orders = [];

    public bool $isAdmin = false;

    public function render()
    {
        return view('livewire.order-list');
    }
}
