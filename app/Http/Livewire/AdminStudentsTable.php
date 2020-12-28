<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;


class AdminStudentsTable extends LivewireDatatable
{
    protected $listeners = ['confirmDelete', '_delete', 'successMessage', 'errorMessage', 'editForm', 'viewForm'];

    public $model = Student::class;

    public $addable = true;
    public $_id;

    private function getData($id)
    {
        return Student::findOrFail($id);
    }
    public function errorMessage($msg)
    {
        session()->flash('errorMessage', $msg);
    }
    public function successMessage($msg)
    {
        session()->flash('message', $msg);
    }
    public function builder()
    {
        return Student::query();
    }
    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->label('ID')
                ->sortBy('id'),

            Column::name('name')
                ->label('Name')->editable(),

            Column::name('nisn')->editable(),
            Column::name('nis')->editable(),

            BooleanColumn::name('is_active')
                ->label('Active')->editable(),
            Column::callback(['id', 'name'], function ($id, $name) {
                return view('livewire.datatables.table-actions', ['id' => $id, 'name' => $name]);
            })->label('Actions')
        ];
    }
    public function confirmDelete($id)
    {
        $this->_id = $id;
    }

    public function _delete()
    {
        $student = Student::findOrFail($this->_id);
        if ($student) {
            $this->delete($this->_id);
            $this->successMessage('Data siswa berhasil dihapus');
        } else {
            $this->errorMessage('Data siswa tidak ditemukan');
        }
        $this->_id = "";
    }
    public function editForm($id)
    {
        $this->emitUp('handleUpdateForm', $this->getData($id));
    }
    public function viewForm($id)
    {
        $this->emitUp('handleViewForm', $this->getData($id));
    }
}
