<?php

namespace App\Http\Livewire\Pages;

use App\Models\Student;
use App\Models\Navs\NavAdmin;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class AdminStudents extends Component
{
    protected $listeners = ['handleUpdateForm', 'handleViewForm'];

    public $model = Student::class;
    public $currentID;
    public $inputMore;
    public $menu;
    public $validation_errors = [];
    public $student = [
        "id" => 0,
        "name" => "",
        "parent_name" => "",
        "nisn" => "",
        "nis" => "",
        "is_active" => "",
    ];
    public function mount()
    {
        $this->menu = NavAdmin::getMenu();
    }
    public function render()
    {
        return view('livewire.pages.admin-students', ['subMenu' => 'Students']);
    }
    public function create()
    {
        $rules = [
            'name' => 'required',
            'nisn' => 'nullable',
            'nis' => 'nullable'
        ];

        $messages = [
            "name.required" => "Nama tidak boleh kosong",
        ];
        $validator_object = Validator::make($this->student, $rules, $messages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {
                $query = [
                    'name' => $this->student['name'],
                    'nisn' => $this->student['nisn'],
                    'nis' => $this->student['nis'],
                    'parent_name' => $this->student['parent_name'],
                ];

                $this->model::insert($query);
                $this->emptyForm();
                if (!$this->inputMore)
                    $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-students-table', 'successMessage', 'Berhasil menambahkan data murid');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-students-table', 'errorMessage', 'Gagal menambahkan data murid');
            }
            return $this->validation_errors = [];
        }
    }
    public function update()
    {
        $rules = [
            'name' => 'required',
            'nisn' => 'nullable',
            'nis' => 'nullable'
        ];

        $messages = [
            "name.required" => "Nama tidak boleh kosong",
        ];
        $validator_object = Validator::make($this->student, $rules, $messages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {
                $query = [
                    'name' => $this->student['name'],
                    'parent_name' => $this->student['parent_name'],
                    'nisn' => $this->student['nisn'],
                    'nis' => $this->student['nis'],
                ];

                $this->model::where('id', $this->currentID)->update($query);

                $this->emptyForm();
                if (!$this->inputMore)
                    $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-students-table', 'successMessage', 'Berhasil memperbarui data murid');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-students-table', 'errorMessage', 'Gagal memperbarui data murid');
            }
            return $this->validation_errors = [];
        }
    }
    public function handleUpdateForm($student)
    {
        $this->currentID = $student['id'];
        $this->student = $student;
    }
    public function handleViewForm($student)
    {
        $this->student = $student;
    }
    public function emptyForm()
    {
        $this->student = [
            "id" => 0,
            "name" => "",
            "parent_name" => "",
            "is_active" => "",
            "nisn" => "",
            "nis" => "",
        ];
    }
}
