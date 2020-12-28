<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use App\Models\TeacherCourse;
use App\Models\TahunAjaran;
use App\Models\Navs\NavAdmin;
use Illuminate\Support\Facades\Validator;

class AdminTeacherCourse extends Component
{
    public $model = TeacherCourse::class;
    protected $listeners = ['handleUpdateForm', 'handleViewForm', 'setTeacher', 'setClass', 'setCourse'];
    public $currentID;
    public $inputMore;
    public $menu;
    public $allTahun;
    public $validation_errors = [];
    public $teacher_course = [
        "id" => 0,
        "user_id" => "",
        "class_id" => "",
        "course_id" => "",
        "tahun_ajaran_id" => "",
    ];
    public $rules = [
        'user_id' => 'required',
        'class_id' => 'required',
        'course_id' => 'required',
        'tahun_ajaran_id' => 'required',
    ];

    private $messages = [
        "user_id.required" => "Guru tidak boleh kosong",
        "course_id.required" => "Mata Pelajaran tidak boleh kosong",
        "class_id.required" => "Kelas tidak boleh kosong",
        "tahun_ajaran_id.required" => "Tahun ajaran tidak boleh kosong",
    ];
    public function mount()
    {
        $this->menu = NavAdmin::getMenu();
        $this->allTahun = TahunAjaran::orderBy('id', 'desc')->get();
    }
    public function handleUpdateForm($teacher_course)
    {
        $this->currentID = $teacher_course['id'];
        $this->teacher_course = $teacher_course;
    }
    public function handleViewForm($teacher_course)
    {
        $this->teacher_course = $teacher_course;
    }
    public function emptyForm()
    {
        $this->teacher_course = [
            "id" => 0,
            "user_id" => "",
            "class_id" => "",
            "course_id" => "",
            "tahun_ajaran_id" => "",
        ];
        $this->emitTo('partials.teacher-search-bar', '_reset');
        $this->emitTo('partials.class-search-bar', '_reset');
        $this->emitTo('partials.course-search-bar', '_reset');
    }

    public function create()
    {
        $validator_object = Validator::make($this->teacher_course, $this->rules, $this->messages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            if ($this->model::where("teacher_id", $this->teacher_course['user_id'])
                ->where("class_id", $this->teacher_course['class_id'])
                ->where("course_id", $this->teacher_course['course_id'])
                ->where("tahun_ajaran_id", $this->teacher_course['tahun_ajaran_id'])->get()->toArray()
            ) {

                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-teacher-course-table', 'errorMessage', 'Gagal menambahkan data Guru Mata Pelajaran: Duplikat Data');
                return;
            }
            try {
                $query = [
                    'teacher_id' => $this->teacher_course['user_id'],
                    'class_id' => $this->teacher_course['class_id'],
                    'course_id' => $this->teacher_course['course_id'],
                    'tahun_ajaran_id' => $this->teacher_course['tahun_ajaran_id'],
                ];
                $this->model::insert($query);
                $this->emptyForm();
                if (!$this->inputMore)
                    $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-teacher-course-table', 'successMessage', 'Berhasil menambahkan data Guru Mata Pelajaran');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-teacher-course-table', 'errorMessage', 'Gagal menambahkan data Guru Mata Pelajaran');
            }
            return $this->validation_errors = [];
        }
    }
    public function update()
    {
        $validator_object = Validator::make($this->teacher_course, $this->rules, $this->messages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {
                $query = [
                    'teacher_id' => $this->teacher_course['user_id'],
                    'class_id' => $this->teacher_course['class_id'],
                    'course_id' => $this->teacher_course['course_id'],
                    'tahun_ajaran_id' => $this->teacher_course['tahun_ajaran_id'],
                ];

                $this->model::where('id', $this->currentID)->update($query);
                $this->emptyForm();

                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-teacher-course-table', 'successMessage', 'Berhasil memperbarui data Guru Mata Pelajaran');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-teacher-course-table', 'errorMessage', 'Gagal memperbarui data Guru Matapelajaran');
            }
            return $this->validation_errors = [];
        }
    }
    public function setTeacher($teacher)
    {
        if ($teacher != null)
            $this->teacher_course['user_id'] = $teacher['id'];
        else
            $this->teacher_course['user_id'] = "";
    }
    public function setClass($class)
    {

        if ($class != null)
            $this->teacher_course['class_id'] = $class['id'];
        else
            $this->teacher_course['class_id'] = "";
    }
    public function setCourse($course)
    {

        if ($course != null)
            $this->teacher_course['course_id'] = $course['id'];
        else
            $this->teacher_course['course_id'] = "";
    }
    public function render()
    {
        return view('livewire.pages.admin-teacher-course', ['subMenu' => 'Teacher Course']);
    }
}
