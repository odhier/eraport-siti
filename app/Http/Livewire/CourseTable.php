<?php

namespace App\Http\Livewire;


use App\Models\TeacherCourse;
use App\Models\WaliKelas;
use App\Models\StudentClass;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Illuminate\Support\Facades\Auth;

class CourseTable extends LivewireDatatable
{
    protected $listeners = ['setId', 'successMessage', 'errorMessage', 'editForm'];
    public $model = TeacherCourse::class;
    public $data;
    public $kode;
    public $class;
    public $tahun;
    public $course_id;

    public $select_semester = true;
    public $selected_semester;


    public function builder()
    {
        return ($this->class && $this->tahun) ? $this->studentClassBuilder() : $this->classBuilder();
    }
    public function columns()
    {
        return ($this->class && $this->tahun) ? $this->studentClassTable() : $this->classTable();
    }
    public function errorMessage($msg)
    {
        session()->flash('errorMessage', $msg);
    }
    public function successMessage($msg)
    {
        session()->flash('message', $msg);
    }

    public function setId($kode = null)
    {
        $this->data = $kode;
    }
    private function classTable()
    {

        return [
            NumberColumn::name('teacher_course.id')
                ->label('ID')
                ->sortBy('teacher_course.id'),

            Column::callback(['class_id', 'tahun_ajaran.tahun_ajaran', 'classes.tingkat', 'classes.name'], function ($class_id, $tahun, $tingkat, $name) {
                return "<a href='/courses/{$this->kode}/{$class_id}/" . str_replace('/', '-', $tahun) . "'>" . $tingkat . " (" . $name . ")</a>";
            })->label('Kelas')->searchable(),
            Column::callback(['class_id', 'tahun_ajaran_id'], function ($class, $tahun) {
                $walikelas = WaliKelas::with('user')->where('class_id', $class)->where('tahun_ajaran_id', $tahun)->first();
                return ($walikelas) ? $walikelas->user->name : "-";
            })->label('Wali Kelas')->searchable(),

            Column::name('tahun_ajaran.tahun_ajaran')->label('Tahun Ajaran'),

        ];
    }
    private function studentClassTable()
    {
        return [
            NumberColumn::name('student_class.id')
                ->label('ID')
                ->sortBy('student_class.id'),

            Column::name('students.name')->label('Siswa')->searchable(),
            Column::callback(['id'], function ($id) {
                return "
                <div class='ui-group-buttons'>
                <span data-toggle='modal' data-target='#assignNilaiModal' class='p-0'>
                <a class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Pengetahuan' wire:click=\"\$emitTo('pages.course','editForm','3','{$id}', '{$this->selected_semester}')\" >
                    KI-3
                </a>
                </span>
                <div class='or'></div>
                <span data-toggle='modal' data-target='#assignNilaiModal' class='p-0'>
                <a class='button btn btn-success' data-toggle='tooltip' data-placement='top' title='Keterampilan' wire:click=\"\$emitTo('pages.course','editForm','4','{$id}', '{$this->selected_semester}')\">
                KI-4
                </a>
                </span>
                </div>
                ";
            })->label('Nilai')->alignRight()
        ];
    }
    private function classBuilder()
    {
        $table = $this->model::query()->leftJoin('users', 'users.id', 'teacher_course.teacher_id')
            ->leftJoin('courses', 'courses.id', 'teacher_course.course_id')
            ->leftJoin('classes', 'classes.id', 'teacher_course.class_id')
            ->leftJoin('tahun_ajaran', 'tahun_ajaran.id', 'teacher_course.tahun_ajaran_id')->where('courses.kode', $this->kode)->where('teacher_course.teacher_id', Auth::user()->id);
        return ($this->tahun) ? $table->where('tahun_ajaran_id', $this->tahun->id) : $table;
    }
    private function studentClassBuilder()
    {
        return StudentClass::query()->leftJoin('students', 'students.id', 'student_class.student_id')
            ->where('class_id', $this->class->id)
            ->where('tahun_ajaran_id', $this->tahun->id);
    }
    public function editForm($ki, $id)
    {
        $this->emitUp('editForm', $ki, $id, $this->selected_semester);
    }
}
