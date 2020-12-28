<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use App\Models\WaliKelas;
use App\Models\TahunAjaran;
use App\Models\Navs\NavAdmin;
use Illuminate\Support\Facades\Validator;

class AdminWaliKelas extends Component
{
    public $model = WaliKelas::class;
    protected $listeners = ['handleUpdateForm', 'handleViewForm', 'setTeacher', 'setClass'];
    public $currentID;
    public $inputMore;
    public $menu;
    public $allTahun;
    public $validation_errors = [];
    public $wali_kelas = [
        "id" => 0,
        "teacher_id" => "",
        "class_id" => "",
        "tahun_ajaran_id" => "",
    ];
    public $rules = [
        'teacher_id' => 'required',
        'class_id' => 'required',
        'tahun_ajaran_id' => 'required',
    ];

    private $messages = [
        "teacher_id.required" => "Guru tidak boleh kosong",
        "class_id.required" => "Kelas tidak boleh kosong",
        "tahun_ajaran_id.required" => "Tahun ajaran tidak boleh kosong",
    ];
    public function mount()
    {
        $this->menu = NavAdmin::getMenu();
        $this->allTahun = TahunAjaran::orderBy('id', 'desc')->get();
    }
    public function handleUpdateForm($wali_kelas)
    {
        $this->currentID = $wali_kelas['id'];
        $this->wali_kelas = $wali_kelas;
    }
    public function handleViewForm($wali_kelas)
    {
        $this->wali_kelas = $wali_kelas;
    }
    public function emptyForm()
    {
        $this->wali_kelas = [
            "id" => 0,
            "teacher_id" => "",
            "class_id" => "",
            "tahun_ajaran_id" => "",
        ];
        $this->emitTo('partials.teacher-search-bar', '_reset');
        $this->emitTo('partials.class-search-bar', '_reset');
    }

    public function create()
    {
        $validator_object = Validator::make($this->wali_kelas, $this->rules, $this->messages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            if ($this->model::where("class_id", $this->wali_kelas['class_id'])
                ->where("tahun_ajaran_id", $this->wali_kelas['tahun_ajaran_id'])->get()->toArray()
            ) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-wali-kelas-table', 'errorMessage', 'Gagal menambahkan data Wali Kelas: Kelas sudah memiliki wali');
                return;
            }
            try {
                $query = [
                    'teacher_id' => $this->wali_kelas['teacher_id'],
                    'class_id' => $this->wali_kelas['class_id'],
                    'tahun_ajaran_id' => $this->wali_kelas['tahun_ajaran_id'],
                ];
                $this->model::insert($query);
                $this->emptyForm();
                if (!$this->inputMore)
                    $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-wali-kelas-table', 'successMessage', 'Berhasil menambahkan data Wali Kelas');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-wali-kelas-table', 'errorMessage', 'Gagal menambahkan data Wali Kelas');
            }
            return $this->validation_errors = [];
        }
    }
    public function update()
    {
        $validator_object = Validator::make($this->wali_kelas, $this->rules, $this->messages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {
                $query = [
                    'teacher_id' => $this->wali_kelas['teacher_id'],
                    'class_id' => $this->wali_kelas['class_id'],
                    'tahun_ajaran_id' => $this->wali_kelas['tahun_ajaran_id'],
                ];

                $this->model::where('id', $this->currentID)->update($query);
                $this->emptyForm();

                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-wali-kelas-table', 'successMessage', 'Berhasil memperbarui data Wali Kelas');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-wali-kelas-table', 'errorMessage', 'Gagal memperbarui data Wali Kelas');
            }
            return $this->validation_errors = [];
        }
    }
    public function setTeacher($teacher)
    {
        if ($teacher != null)
            $this->wali_kelas['teacher_id'] = $teacher['id'];
        else
            $this->wali_kelas['teacher_id'] = "";
    }
    public function setClass($class)
    {

        if ($class != null)
            $this->wali_kelas['class_id'] = $class['id'];
        else
            $this->wali_kelas['class_id'] = "";
    }
    public function render()
    {
        return view('livewire.pages.admin-wali-kelas', ['subMenu' => 'Wali Kelas']);
    }
}
