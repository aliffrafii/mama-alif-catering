<?php

namespace App\Livewire;

use Livewire\Component;

class StatsCard extends Component
{
    public string $title = '';
    public string $value = '';
    public string $icon = '';
    public string $color = 'gray';

    public function render()
    {
        return view('livewire.stats-card');
    }
}
