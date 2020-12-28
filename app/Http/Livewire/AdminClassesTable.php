<?php

namespace App\Http\Livewire;

use App\Models\Classes;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;

class AdminClassesTable extends LivewireDatatable
{
    public $model = Classes::class;
    protected $listeners = ['confirmDelete', '_delete', 'successMessage', 'errorMessage', 'editForm', 'viewForm'];

    public $addable = true;
    public $_id;


    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->label('ID')
                ->sortBy('id'),
            Column::name('tingkat')->label('Tingkat Kelas')->editable(),

            Column::name('name')
                ->label('Nama Kelas')->editable(),

            BooleanColumn::name('is_active')
                ->label('Active')->editable(),
            Column::callback(['id'], function ($id) {
                return view('livewire.datatables.table-actions', ['id' => $id]);
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
    public function builder()
    {
        return $this->model::query();
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
            $this->successMessage('Data kelas berhasil dihapus');
        } else {
            $this->errorMessage('Data kelas tidak ditemukan');
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
