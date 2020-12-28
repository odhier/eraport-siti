<?php

namespace App\Http\Livewire\Pages;

use App\Models\GeneralSetting;
use Livewire\Component;
use App\Models\Navs\NavAdmin;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Validator;

class AdminGeneral extends Component
{
    public $model = GeneralSetting::class;
    public $menu;
    public $allTahun;
    public $general = ['tahun_ajaran_aktif' => "", 'semester_aktif' => 1];
    public $validation_errors = [];
    public $rules = [
        'tahun_ajaran_aktif' => 'required',
        'semester_aktif' => 'required',
    ];

    private $messages = [
        "tahun_ajaran_aktif.required" => "Tahun ajaran tidak boleh kosong",
        "semester_aktif.required" => "Semester saat ini tidak boleh kosong",
    ];
    public function mount()
    {
        $this->menu = NavAdmin::getMenu();
        $this->allTahun = TahunAjaran::orderBy('id', 'desc')->get();
        $setting_tahun = $this->model::select('setting_value')->where('setting_name', 'tahun_ajaran_aktif')->first();
        $setting_semester = $this->model::select('setting_value')->where('setting_name', 'semester_aktif')->first();
        $this->general['tahun_ajaran_aktif'] = ($setting_tahun) ? $setting_tahun->setting_value : "";
        $this->general['semester_aktif'] = ($setting_semester) ? $setting_semester->setting_value : "";
    }
    public function render()
    {
        return view('livewire.pages.admin-general', ['subMenu' => 'General Setting']);
    }
    public function save()
    {
        $validator_object = Validator::make($this->general, $this->rules, $this->messages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {
                foreach ($this->general as $key => $value) {
                    $this->model::updateOrInsert(
                        ['setting_name' => $key],
                        ['setting_value' => $value]
                    );
                }
                session()->flash('successMessage', "Berhasil Menyimpan Setting");
            } catch (\Exception $e) {
                session()->flash('errorMessage', "Gagal Menyimpan Setting");
            }
        }
        return $this->validation_errors = [];
    }
}
