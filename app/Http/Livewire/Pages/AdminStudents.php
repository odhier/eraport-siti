<?php

namespace App\Http\Livewire\Pages;

use App\Models\Student;
use App\Models\Navs\NavAdmin;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;
use App\Imports\StudentsImport;
use App\Models\TahunAjaran;
use Maatwebsite\Excel\Facades\Excel;

class AdminStudents extends Component
{
    use WithFileUploads;
    protected $listeners = ['handleUpdateForm', 'handleViewForm', 'setClass', 'successAppoint'];

    public $savingAppoint=false;
    public $model = Student::class;
    public $isUploading = false;
    public $excel;
    public $currentID;
    public $inputMore;
    public $menu;
    public $validation_errors = [];
    public $allTahun;
    public $SClass = [
        "class_id" => "",
        "tahun_ajaran_id" => "",
    ];
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
        $this->allTahun = TahunAjaran::orderBy('id', 'desc')->get();
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
    public function setClass($class)
    {

        if ($class != null)
            $this->SClass['class_id'] = $class['id'];
        else
            $this->SClass['class_id'] = "";
    }
    public function import(){
        $this->isUploading=true;
        try{
        $array = Excel::toArray(new StudentsImport, $this->excel);
        $data = array();
        for($i = 1;$i < count($array[0]); $i++){
            if($array[0][$i][0] && $array[0][$i][0] != ""){
            $data[] = [
                'name' => $array[0][$i][0],
                'nisn' => $array[0][$i][1],
                'nis' => $array[0][$i][2],
                'parent_name' => $array[0][$i][3],
                'created_at' => \Carbon\Carbon::now()
            ];
        }
        }
        Student::insert($data);


        $this->validation_errors = [];
        $this->dispatchBrowserEvent('closeModal');
        $this->emitTo('admin-students-table', 'successMessage', 'Berhasil import data');
    }catch(\Exception $e){
        dd($e);
        $this->dispatchBrowserEvent('closeModal');
        $this->emitTo('admin-students-table', 'errorMessage', 'Gagal import data, Pastikan file excel adalah hasil export');
    }

    $this->isUploading=false;
    }
    public function successAppoint(){
        $this->savingAppoint = false;
        $this->dispatchBrowserEvent('closeModal');
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

        $this->emitTo('partials.class-search-bar', '_reset');
    }
}
