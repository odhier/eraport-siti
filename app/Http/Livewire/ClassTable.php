<?php

namespace App\Http\Livewire;

use App\Models\Absensi;
use App\Models\GeneralSetting;
use App\Models\KompetensiInti;
use App\Models\KompetensiIntiDetail;
use App\Models\Saran;
use App\Models\StudentClass;
use App\Models\WaliKelas;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassTable extends LivewireDatatable
{
    protected $listeners = ['successMessage', 'errorMessage', 'editForm', 'editAbsensi'];
    public $select_semester = true;
    public $legger = true;
    public $selected_semester;
    public $KI;
    public $class;
    public function builder()
    {
        $this->KI = KompetensiInti::all();
        if (!$this->selected_semester) {
            $setting_semester = GeneralSetting::select('setting_value')->where('setting_name', 'semester_aktif')->first();
            $this->selected_semester = ($setting_semester) ? $setting_semester->setting_value : 1;
        }
        return StudentClass::query()->leftJoin('absensi', function ($join) {
            $join->on('student_class.id', '=', 'absensi.student_class_id')->where('absensi.semester', '=', 1);
        })
            ->leftJoin('students', 'students.id', 'student_class.student_id')
            ->select('student_class.id AS id', 'students.name', 'absensi.sakit')
            ->where('class_id', $this->class->class->id)
            ->where('tahun_ajaran_id', $this->class->tahun_ajaran_id);
    }

    public function columns()
    {

        return [
            Column::callback('student_class.id, students.id', function ($id) {
                return "
                    <a href='{$this->class->id}/{$this->selected_semester}/{$id}/'>Detail Nilai</a>
                    ";
            })->label('Detail')->alignCenter(),
            Column::name('students.name')->label('Siswa')->searchable()->filterable(),
            Column::callback('student_class.student_id,student_class.id', function ($student_id, $id) {
                $saran = Saran::where('student_class_id', $id)->where('semester', $this->selected_semester)->first();
                return ($saran) ? $saran->saran : "";
            })->label('Saran'),
            NumberColumn::callback('student_class.id, student_class.student_id', function ($id) {
                return "<a data-toggle='modal' data-target='#physique-modal' wire:click.prevent=\$emitTo('partials.modals.physique','open','{$id}','{$this->selected_semester}') class='text-teal-500 hover:text-teal-600 cursor-pointer')>Fisik & Kondisi Kesehatan</a>";
            })->label('Fisik')->alignCenter(),
            NumberColumn::callback(['student_class.id'], function ($id) {
                return "<a data-toggle='modal' data-target='#ekstrakurikuler-modal' wire:click.prevent=\$emitTo('partials.modals.ekstrakurikuler','open','{$id}','{$this->selected_semester}') class='text-teal-500 hover:text-teal-600 cursor-pointer')>Ekstrakurikuler</a>";
            })->label('Fisik')->alignCenter(),

            Column::callback('student_class.id', function ($id) {
                return "<a data-toggle='modal' data-target='#assignAbsensi'  wire:click=\$emitSelf('editAbsensi','{$id}') class='text-teal-500 hover:text-teal-600 cursor-pointer')>Absensi & Saran</a>";
            })->label('Nilai')->alignCenter(),

            Column::callback(['student_class.student_id', 'student_class.id'], function ($student_id, $id) {
                $val = "<div class='ui-group-buttons space-y-1'>";
                foreach ($this->KI as $ki) {
                    $val .= "<span data-toggle='modal' data-target='#assignNilaiModal' class='p-0'>
                    <a class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='{$ki->name}' wire:click=\$emitSelf('editForm','{$ki->id}','{$id}') >
                        KI-{$ki->kode}
                    </a>
                    </span>
                    <div></div>";
                }
                $val .= "</div>";
                return $val;
            })->label('Nilai')->alignCenter(),
            Column::callback(['id'], function ($id) {
                return "
                <a target='_blank' href='/raport/cetak_pdf/{$this->class->tahun_ajaran_id}_{$this->class->id}_{$this->selected_semester}_{$id}' class='border-orange-500 border-opacity-75 border-2 rounded-xl p-1 shadow-sm text-orange-500 hover:text-orange-500 hover:no-underline cursor-pointer'>Print Nilai <i class='fas fa-print'></i></a>
                ";
            })->label('Print')->alignRight()
        ];
    }
    public function editForm($ki, $id)
    {
        $this->emitUp('editForm', $ki, $id, $this->selected_semester);
    }
    public function editAbsensi($id)
    {
        $this->emitUp('editAbsensi', $id, $this->selected_semester);
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
