<?php

namespace App\Http\Livewire\Partials\Modals;

use Livewire\Component;

class Physique extends Component
{
    public $angka=1;
    protected $listeners = ['open' => 'loadForm'];

    public function increment(){
        $this->angka++;
    }
    public function loadForm($id){
        $this->emit('togglePhysiqueFormModal');
    }
    public function render()
    {
        return view('livewire.partials.modals.physique');
    }
}
