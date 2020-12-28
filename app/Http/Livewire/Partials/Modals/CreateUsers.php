<?php

namespace App\Http\Livewire\Partials\Modals;

use Livewire\Component;

class CreateUsers extends Component
{
    protected $listeners = ['_close'];
    public $inputPhoto;

    public function render()
    {
        return view('livewire.partials.modals.create-users');
    }
}
