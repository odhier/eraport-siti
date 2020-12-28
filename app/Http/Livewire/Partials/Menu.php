<?php

namespace App\Http\Livewire\Partials;

use App\Models\GeneralSetting;
use App\Models\TahunAjaran;
use Livewire\Component;

class Menu extends Component
{
    protected $listeners = ['rerenderSidebar' => '$refresh', 'getNewMenu'];
    public $post;
    public $tahun;
    public $allTahun;

    public function mount()
    {
        $this->allTahun = TahunAjaran::orderBy('id', 'desc')->get();

        $current_year = GeneralSetting::select('setting_value')->where('setting_name', 'tahun_ajaran_aktif')->first();
        $this->tahun = ($current_year) ? $current_year->setting_value : "";
    }

    public function changeTahun()
    {
        // $this->emitTo('pages.course', 'rerenderSidebar');
        $this->emitTo('pages.course', 'changeTahun', $this->tahun);
    }
    public function getNewMenu($menu)
    {
        $this->post = $menu;
    }
    public $update;

    public function refreshComponent()
    {
        $this->update = !$this->update;
    }
    public function render()
    {
        return view('livewire.partials.menu');
    }
}
