<?php

namespace App\Http\Livewire\Partials;

use App\Models\GeneralSetting;
use App\Models\TahunAjaran;
use Livewire\Component;

class MenuClass extends Component
{
    public $menu;
    public $allTahun;
    public $tahun;
    public $tahun_id;
    public function mount()
    {
        $this->allTahun = TahunAjaran::orderBy('id', 'desc')->get();
        if (!$this->tahun_id) {
            $current_year = GeneralSetting::select('setting_value')->where('setting_name', 'tahun_ajaran_aktif')->first();
            $this->tahun = ($current_year) ? $current_year->setting_value : "";
        } else {
            $this->tahun = $this->tahun_id;
        }
    }

    public function render()
    {
        return view('livewire.partials.menu-class');
    }
}
