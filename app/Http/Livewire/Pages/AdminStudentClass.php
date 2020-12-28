<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use App\Models\StudentClass;
use App\Models\TahunAjaran;
use App\Models\Navs\NavAdmin;
use Illuminate\Support\Facades\Validator;

class AdminStudentClass extends Component
{
    public $model = StudentClass::class;
    protected $listeners = ['handleUpdateForm', 'handleViewForm', 'setStudent', 'setClass'];
    public $currentID;
    public $inputMore;
    public $menu;
    public $allTahun;
    public $validation_errors = [];
    public $SClass = [
        "id" => 0,
        "student_id" => "",
        "class_id" => "",
        "tahun_ajaran_id" => "",
    ];
    public $rules = [
        'student_id' => 'required',
        'class_id' => 'required',
        'tahun_ajaran_id' => 'required',
    ];

    private $messages = [
        "student_id.required" => "Siswa tidak boleh kosong",
        "class_id.required" => "Kelas tidak boleh kosong",
        "tahun_ajaran_id.required" => "Tahun ajaran tidak boleh kosong",
    ];
    public function mount()
    {
        $this->menu = NavAdmin::getMenu();
        $this->allTahun = TahunAjaran::orderBy('id', 'desc')->get();
    }
    public function handleUpdateForm($SClass)
    {
        $this->currentID = $SClass['id'];
        $this->SClass = $SClass;
    }
    public function handleViewForm($SClass)
    {
        $this->SClass = $SClass;
    }
    public function emptyForm()
    {
        $this->SClass = [
            "id" => 0,
            "student_id" => "",
            "class_id" => "",
            "tahun_ajaran_id" => "",
        ];
        $this->emitTo('partials.student-search-bar', '_reset');
        $this->emitTo('partials.class-search-bar', '_reset');
    }

    public function create()
    {
        $validator_object = Validator::make($this->SClass, $this->rules, $this->messages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            if ($this->model::where("student_id", $this->SClass['student_id'])
                ->where("class_id", $this->SClass['class_id'])
                ->where("tahun_ajaran_id", $this->SClass['tahun_ajaran_id'])->first()
            ) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-student-class-table', 'errorMessage', 'Gagal menambahkan data kelas siswa: Duplikat Data');
                return;
            }
            try {
                $query = [
                    'student_id' => $this->SClass['student_id'],
                    'class_id' => $this->SClass['class_id'],
                    'tahun_ajaran_id' => $this->SClass['tahun_ajaran_id'],
                ];
                $this->model::insert($query);
                $this->emptyForm();
                if (!$this->inputMore)
                    $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-student-class-table', 'successMessage', 'Berhasil menambahkan data kelas siswa');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-student-class-table', 'errorMessage', 'Gagal menambahkan data kelas siswa');
            }
            return $this->validation_errors = [];
        }
    }
    public function update()
    {
        $validator_object = Validator::make($this->SClass, $this->rules, $this->messages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {
                $query = [
                    'student_id' => $this->SClass['student_id'],
                    'class_id' => $this->SClass['class_id'],
                    'tahun_ajaran_id' => $this->SClass['tahun_ajaran_id'],
                ];

                $this->model::where('id', $this->currentID)->update($query);
                $this->emptyForm();

                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-student-class-table', 'successMessage', 'Berhasil memperbarui data Kelas siswa');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-student-class-table', 'errorMessage', 'Gagal memperbarui data Kelas siswa');
            }
            return $this->validation_errors = [];
        }
    }
    public function setStudent($student)
    {
        if ($student != null)
            $this->SClass['student_id'] = $student['id'];
        else
            $this->SClass['student_id'] = "";
    }
    public function setClass($class)
    {

        if ($class != null)
            $this->SClass['class_id'] = $class['id'];
        else
            $this->SClass['class_id'] = "";
    }
    public function render()
    {
        return view('livewire.pages.admin-student-class', ['subMenu' => 'Student Class']);
    }
}
