<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;

use App\Models\Course;
use App\Models\Navs\NavAdmin;
use Illuminate\Support\Facades\Validator;

class AdminCourses extends Component
{
    public $model = Course::class;
    protected $listeners = ['handleUpdateForm', 'handleViewForm'];
    public $currentID;
    public $inputMore;
    public $menu;
    public $validation_errors = [];
    public $course = [
        "id" => 0,
        "name" => "",
        "kode" => "",
        "is_active" => "",
    ];
    private $rules = [
        'name' => 'required',
        'kode' => 'required|max:4',
    ];

    private $messages = [
        "name.required" => "Nama tidak boleh kosong",
        "kode.required" => "Kode mata pelajaran tidak boleh kosong",
        "kode.max" => "Kode mata pelajaran maksimal 4 huruf",
    ];

    public function render()
    {
        return view('livewire.pages.admin-courses', ['subMenu' => 'Courses']);
    }
    public function mount()
    {
        $this->menu = NavAdmin::getMenu();
    }
    public function handleUpdateForm($course)
    {
        $this->currentID = $course['id'];
        $this->course = $course;
    }
    public function handleViewForm($course)
    {
        $this->course = $course;
    }
    public function emptyForm()
    {
        $this->course = [
            "id" => 0,
            "name" => "",
            "is_active" => "",
            "kode" => "",
        ];
    }

    public function create()
    {

        $validator_object = Validator::make($this->course, $this->rules, $this->messages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {
                $query = [
                    'name' => $this->course['name'],
                    'kode' => $this->course['kode'],
                ];



                $this->model::insert($query);
                $this->emptyForm();
                if (!$this->inputMore)
                    $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-courses-table', 'successMessage', 'Berhasil menambahkan data murid');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-course-table', 'errorMessage', 'Gagal menambahkan data murid');
            }
            return $this->validation_errors = [];
        }
    }
    public function update()
    {
        $validator_object = Validator::make($this->course, $this->rules, $this->messages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {
                $query = [
                    'name' => $this->course['name'],
                    'kode' => $this->course['kode'],
                ];

                $this->model::where('id', $this->currentID)->update($query);
                $this->emptyForm();

                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-courses-table', 'successMessage', 'Berhasil memperbarui mata pelajaran');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-courses-table', 'errorMessage', 'Gagal memperbarui mata pelajaran');
            }
            return $this->validation_errors = [];
        }
    }
}
