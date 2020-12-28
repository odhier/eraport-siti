<?php

namespace App\Http\Livewire\Pages;

use App\Models\Course;
use App\Models\Classes;
use App\Models\GeneralSetting;
use App\Models\KKM;
use Livewire\Component;
use App\Models\KompetensiDasar;
use App\Models\TahunAjaran;
use App\Models\Navs\NavAdmin;
use Illuminate\Support\Facades\Validator;

class AdminKompetensiDasar extends Component
{
    protected $listeners = ['editForm'];
    private $model = KompetensiDasar::class;
    public $subMenu = "Kompetensi Dasar & KKM";
    public $menu;
    public $inputMore;
    public $data = [
        'tingkat_kelas' => 'I',
        'tahun_ajaran_id' => '',
        'kkm' => ['value' => ''],
    ];

    public $allTahun;
    public $allTingkat;
    public $current_ki = 0;
    public $course;
    public $kds = [''];
    public $validation_errors = [];
    public $custom_rules = [
        'tingkat_kelas' => 'required',
        'course_id' => 'required',
        'tahun_ajaran_id' => 'required',
    ];
    public $rules = [
        'data.kkm.value' => 'numeric|min:0|max:100',
    ];
    public $deleteLists = [];

    private $custom_messages = [
        "course_id.required" => "Pelajaran tidak boleh kosong",
        "tingkat_kelas.required" => "Kelas tidak boleh kosong",
        "tahun_ajaran_id.required" => "Tahun ajaran tidak boleh kosong",
    ];
    public $messages = [
        "data.kkm.value.numeric" => "Nilai hanya berupa angka",
        "data.kkm.value.min" => "Nilai min = 0",
        "data.kkm.value.max" => "Nilai max = 100",
    ];

    public function mount()
    {
        $this->menu = NavAdmin::getMenu();
        $this->allTahun = TahunAjaran::orderBy('id', 'desc')->get();
        $this->allTingkat = Classes::tingkat;
        $current_year = GeneralSetting::select('setting_value')->where('setting_name', 'tahun_ajaran_aktif')->first();
        $this->data['tahun_ajaran_id'] = ($current_year) ? $current_year->setting_value : "";
    }
    public function render()
    {
        return view('livewire.pages.admin-kompetensi-dasar');
    }
    public function editForm($ki, $id)
    {
        $this->deleteLists = [];
        $this->current_ki = $ki;
        $this->course = Course::find($id);
        $this->data['course_id'] = ($this->course) ? $this->course->id : "";
        $kds = $this->getKD($this->data['tingkat_kelas'], $this->data['tahun_ajaran_id']);
        $this->kds = ($kds->toArray()) ? [] : [''];
        foreach ($kds as $kd) {
            $this->kds[] = ['id' => $kd->id, 'value' => $kd->value];
        }
        $kkm = $this->getKKM($this->data['tingkat_kelas'], $this->data['tahun_ajaran_id']);
        $this->data['kkm'] = ($kkm) ? $kkm->toArray() : ['value' => ''];
    }
    public function addKD()
    {
        $this->kds[] = '';
        $this->dispatchBrowserEvent('focusLast', ['id' => 'inputKd-' . count($this->kds)]);
    }
    public function removeKD($index, $id)
    {
        if ($id > 0)
            $this->deleteLists[] = $id;
        unset($this->kds[$index]);
    }
    public function emptyForm()
    {
        $this->kds = [''];
        $this->deleteLists = [];
        $this->data = ['course_id' => '', 'tingkat_kelas' => 'I', 'kkm' => ['value' => '']];
        $current_year = GeneralSetting::select('setting_value')->where('setting_name', 'tahun_ajaran_aktif')->first();
        $this->data['tahun_ajaran_id'] = ($current_year) ? $current_year->setting_value : "";
    }
    public function save()
    {
        $validator_object = Validator::make($this->data, $this->custom_rules, $this->custom_messages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {
                //Insert or Update KKM
                $query = [
                    'course_id' => $this->data['course_id'],
                    'tingkat_kelas' => $this->data['tingkat_kelas'],
                    'tahun_ajaran_id' => $this->data['tahun_ajaran_id'],
                    'value' => $this->data['kkm']['value'],
                    'ki' => $this->current_ki,
                ];
                if (isset($this->data['kkm']['id'])) {
                    $query["updated_at"] = \Carbon\Carbon::now();
                    KKM::where('id', $this->data['kkm']['id'])
                        ->update($query);
                } else {
                    $query["created_at"] = \Carbon\Carbon::now();
                    KKM::insert($query);
                }
                //end insert or update kkm

                //Insert or Update Kompetensi Dasar
                $kds = array_filter($this->kds);
                foreach ($kds as $kd) {
                    $query = [
                        'course_id' => $this->data['course_id'],
                        'tingkat_kelas' => $this->data['tingkat_kelas'],
                        'tahun_ajaran_id' => $this->data['tahun_ajaran_id'],
                        'value' => $kd['value'],
                        'ki' => $this->current_ki,
                    ];

                    if (isset($kd['id'])) {
                        $query["updated_at"] = \Carbon\Carbon::now();
                        $this->model::where('id', $kd['id'])
                            ->update($query);
                    } else {
                        $query["created_at"] = \Carbon\Carbon::now();

                        $this->model::insert($query);
                    }
                }
                //end insert or update kompetensi dasar

                //menghapus kompetensi dasar
                if ($this->deleteLists) {
                    $this->model::destroy($this->deleteLists);
                }

                $this->emptyForm();
                if (!$this->inputMore)
                    $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-kompetensi-dasar-table', 'successMessage', 'Berhasil memperbarui data Kompetensi Dasar');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-kompetensi-dasar-table', 'errorMessage', 'Gagal memperbarui data Kompetensi Dasar');
            }
            $this->validation_errors = [];
        }
    }
    public function getKD($tingkat = null, $tahun = null)
    {
        return $this->model::where('course_id', $this->course->id)->when($tingkat, function ($query, $tingkat) {
            return $query->where('tingkat_kelas', $tingkat);
        })->where('tahun_ajaran_id', (!empty($tahun)) ? $tahun : 0)
            ->where('ki', $this->current_ki)->get();
    }
    public function getKKM($tingkat = null, $tahun = null)
    {
        return KKM::where('course_id', $this->course->id)->when($tingkat, function ($query, $tingkat) {
            return $query->where('tingkat_kelas', $tingkat);
        })->where('tahun_ajaran_id', (!empty($tahun)) ? $tahun : 0)
            ->where('ki', $this->current_ki)->first();
    }

    public function changeParam()
    {
        $kkm = $this->getKKM($this->data['tingkat_kelas'], $this->data['tahun_ajaran_id']);
        $this->data['kkm'] = ($kkm) ? $kkm->toArray() : ['value' => ''];
        $kds = $this->getKD($this->data['tingkat_kelas'], $this->data['tahun_ajaran_id']);

        $this->kds = ($kds->toArray()) ? [] : [''];
        foreach ($kds as $kd) {
            $this->kds[] = ['id' => $kd->id, 'value' => $kd->value];
        }
        $this->deleteLists = [];
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
