<?php

namespace App\Http\Livewire;

use App\Models\TeacherCourse;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;

class AdminTeacherCourseTable extends LivewireDatatable
{
    public $model = TeacherCourse::class;
    protected $listeners = ['confirmDelete', '_delete', 'successMessage', 'errorMessage', 'editForm', 'viewForm'];

    public $addable = true;
    public $_id;

    public function builder()
    {
        return $this->model::query()->leftJoin('users', 'users.id', 'teacher_course.teacher_id')
            ->leftJoin('courses', 'courses.id', 'teacher_course.course_id')
            ->leftJoin('classes', 'classes.id', 'teacher_course.class_id')
            ->leftJoin('tahun_ajaran', 'tahun_ajaran.id', 'teacher_course.tahun_ajaran_id');
    }
    public function columns()
    {
        return [

            NumberColumn::name('teacher_course.id')
                ->label('ID')
                ->sortBy('teacher_course.id'),

            Column::name('courses.name')->label('Pelajaran'),
            Column::name('users.name')->label('Nama Guru'),
            Column::callback(['classes.tingkat', 'classes.name'], function ($tingkat, $name) {
                return $tingkat . " (" . $name . ")";
            })->label('Kelas'),

            Column::name('tahun_ajaran.tahun_ajaran')->label('Tahun Ajaran'),
            Column::callback(['id'], function ($id) {
                return view('livewire.datatables.table-actions-noview', ['id' => $id]);
            })->label('Actions')
        ];
    }

    private function getData($id)
    {
        return $this->model::findOrFail($id);
    }
    public function errorMessage($msg)
    {
        session()->flash('errorMessage', $msg);
    }
    public function successMessage($msg)
    {
        session()->flash('message', $msg);
    }

    public function confirmDelete($id)
    {
        $this->_id = $id;
    }

    public function _delete()
    {

        $class = $this->model::findOrFail($this->_id);
        if ($class) {
            $this->delete($this->_id);
            $this->successMessage('Data Guru Mata Pelajaran berhasil dihapus');
        } else {
            $this->errorMessage('Data Guru Mata Pelajaran tidak ditemukan');
        }
        $this->_id = "";
    }
    public function editForm($id)
    {
        $this->emitUp('handleUpdateForm', $this->getData($id));
        $this->emitTo('partials.teacher-search-bar', '_getName', $this->getData($id)['teacher_id']);
        $this->emitTo('partials.class-search-bar', '_getName', $this->getData($id)['class_id']);
        $this->emitTo('partials.course-search-bar', '_getName', $this->getData($id)['course_id']);
    }
    public function viewForm($id)
    {
        $this->emitUp('handleViewForm', $this->getData($id));
    }
}
