<?php

namespace App\Http\Livewire;

use App\Models\StudentClass;
use App\Models\TahunAjaran;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;

class AdminStudentClassTable extends LivewireDatatable
{
    public $model = StudentClass::class;
    protected $listeners = ['confirmDelete', '_delete', 'successMessage', 'errorMessage', 'editForm', 'viewForm'];

    public $addable = true;
    public $_id;

    public function builder()
    {
        return $this->model::query()->leftJoin('students', 'students.id', 'student_class.student_id')
            ->leftJoin('classes', 'classes.id', 'student_class.class_id')
            ->leftJoin('tahun_ajaran', 'tahun_ajaran.id', 'student_class.tahun_ajaran_id');
    }
    public function columns()
    {
        $tahun_ajaran = TahunAjaran::pluck('tahun_ajaran')->toArray();
        return [
            // Column::checkbox(),
            NumberColumn::name('student_class.id')
                ->label('ID')
                ->sortBy('student_class.id'),

            Column::name('students.name')->label('Nama Siswa'),
            Column::callback(['classes.tingkat', 'classes.name'], function ($tingkat, $name) {
                return $tingkat . " (" . $name . ")";
            })->label('Kelas')->filterable(),

            Column::name('tahun_ajaran.tahun_ajaran')->label('Tahun Ajaran')->filterable($tahun_ajaran),
            Column::callback(['id'], function ($id) {
                return view('livewire.datatables.table-actions-noview', ['id' => $id]);
            })->label('Actions')
            // Column::callback(['id'], function ($id) {
            //     return view('livewire.datatables.table-actions', ['id' => $id]);
            // })->label('Actions')
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
            $this->successMessage('Data kelas siswa berhasil dihapus');
        } else {
            $this->errorMessage('Data kelas siswa tidak ditemukan');
        }
        $this->_id = "";
    }
    public function editForm($id)
    {
        $this->emitUp('handleUpdateForm', $this->getData($id));
        $this->emitTo('partials.student-search-bar', '_getName', $this->getData($id)['student_id']);
        $this->emitTo('partials.class-search-bar', '_getName', $this->getData($id)['class_id']);
    }
    public function viewForm($id)
    {
        $this->emitUp('handleViewForm', $this->getData($id));
    }
}
