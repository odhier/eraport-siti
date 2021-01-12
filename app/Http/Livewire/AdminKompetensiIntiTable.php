<?php

namespace App\Http\Livewire;

use App\Models\KompetensiInti;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;

class AdminKompetensiIntiTable extends LivewireDatatable
{

    protected $listeners = ['confirmDelete', '_delete', 'successMessage', 'errorMessage'];
    public $addable = true;
    public $_id;
    public $model = KompetensiInti::class;

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

            NumberColumn::name('kode')
                ->label('Kode')->editable(),
            Column::name('name')
                ->label('Nama')->editable(),
            Column::callback('id', function ($id) {
                return "<span data-toggle='modal' data-target='#kimodal' class='p-0'>
                    <a class='btn btn-primary' data-toggle='tooltip' data-placement='top' wire:click=\$emitUp('editForm','" . $id . "') >
                        Edit Kompetensi
                    </a>
                    </span>";
            })->label('Kompetensi'),
            Column::callback(['id'], function ($id) {
                return view('livewire.datatables.table-actions-delete-only', ['id' => $id]);
            })->label('Actions')
        ];
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
            $this->successMessage('Data Kompetensi Inti berhasil dihapus');
        } else {
            $this->errorMessage('Data Kompetensi Inti tidak ditemukan');
        }
        $this->_id = "";
    }
    public function errorMessage($msg)
    {
        session()->flash('errorMessage', $msg);
    }
    public function successMessage($msg)
    {
        session()->flash('message', $msg);
    }
}
