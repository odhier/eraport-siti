<?php

namespace App\Http\Livewire;

use App\Models\Course;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;

class AdminCoursesTable extends LivewireDatatable
{
    protected $listeners = ['confirmDelete', '_delete', 'successMessage', 'errorMessage', 'editForm', 'viewForm'];

    public $model = Course::class;

    public $addable = true;
    public $_id;

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
    public function builder()
    {
        return $this->model::query();
    }
    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->label('ID')
                ->sortBy('id'),

            Column::name('name')
                ->label('Mata Pelajaran')->editable(),

            Column::name('kode')->label('Kode Mapel')->editable(),

            BooleanColumn::name('is_active')
                ->label('Active')->editable(),
            Column::callback(['id'], function ($id) {
                return view('livewire.datatables.table-actions', ['id' => $id]);
            })->label('Actions')
        ];
    }
    public function confirmDelete($id)
    {
        $this->_id = $id;
    }

    public function _delete()
    {
        $student = $this->model::findOrFail($this->_id);
        if ($student) {
            $this->delete($this->_id);
            $this->successMessage('Data mata pelajaran berhasil dihapus');
        } else {
            $this->errorMessage('Data mata pelajaran tidak ditemukan');
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
