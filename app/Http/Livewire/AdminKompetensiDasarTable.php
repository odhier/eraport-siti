<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\KompetensiDasar;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;

class AdminKompetensiDasarTable extends LivewireDatatable
{
    protected $listeners = ['editForm', 'successMessage', 'errorMessage'];
    public $model = KompetensiDasar::class;

    public function builder()
    {
        return Course::query();
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

            Column::callback(['id'], function ($id) {
                return "
                <div class='ui-group-buttons'>

                <span data-toggle='modal' data-target='#kdmodal' class='p-0'>
                <a class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Pengetahuan' wire:click=\$emitUp('editForm','3','" . $id . "') >
                    <span data-toggle='modal' data-target='#kdmodal'>KD KI-3
                </a>
                </span>
                <div class='or'></div>
                <span data-toggle='modal' data-target='#kdmodal' class='p-0'>
                <a class='button btn btn-success' data-toggle='tooltip' data-placement='top' title='Keterampilan' wire:click=\$emitUp('editForm','4','" . $id . "')'>
                KD KI-4
                </a>
                </span>
                </div>
                ";
            })->label('Action')
        ];
    }
    public function editForm($ki, $id)
    {
        $this->current_ki = $ki;
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
