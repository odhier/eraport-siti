<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Menubar extends Component
{
    public $tab;

    public function render()
    {
        return view('livewire.menubar');
    }
}
