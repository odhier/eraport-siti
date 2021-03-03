<?php

namespace App\Http\Livewire;

use App\Models\Absensi;
use App\Models\Student;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;

use App\Exports\StudentsExport;
use App\Models\StudentClass;
use Maatwebsite\Excel\Facades\Excel;


class AdminStudentsTable extends LivewireDatatable
{
    protected $listeners = ['confirmDelete', '_delete', 'successMessage', 'errorMessage', 'editForm', 'viewForm', 'appoint'];

    public $model = Student::class;

    public $addable = true;
    public $_id;
    public $appointClass = true;
    //untuk menampilkan button export
    public $class = "";
    public $export;

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
        $this->export = "/admin/students/export";
        return [
            Column::checkbox()->label('Select'),
            NumberColumn::name('id')
                ->label('ID')
                ->sortBy('id'),

            Column::name('name')
                ->label('Name')->editable(),
            Column::name('parent_name')
                ->label('Orang Tua/Wali')->editable(),

            Column::name('nisn')->editable(),
            Column::name('nis')->editable(),

            BooleanColumn::name('is_active')
                ->label('Active')->editable(),
            Column::callback(['id', 'name'], function ($id, $name) {
                // return view('livewire.datatables.table-actions', ['id' => $id, 'name' => $name]);
                return '<div class="flex space-x-1 justify-around">
                <a data-toggle="modal" data-target="#editModal" wire:click="$emitTo(\'pages.admin-student-class\',\'editForm\',\''.$id.'\')" wire:click="editForm({{$id}})" class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
                </a>

                <button data-toggle="modal" data-target="#deleteModal" wire:click="confirmDelete('.$id.')" class="p-1 text-red-600 hover:bg-red-600 hover:text-white rounded">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                </button>


            </div>';
            })->label('Actions')
        ];
    }
    public function appoint($class_id, $tahun_ajaran_id){
        $i = 0;
        try{
        foreach($this->selected as $selectedStudent){
            StudentClass::firstOrCreate([
                'student_id' => $selectedStudent,
                'class_id' => $class_id,
                'tahun_ajaran_id'=> $tahun_ajaran_id
            ],[
                'created_at' => \Carbon\Carbon::now()
            ]);
        }
        $this->emitTo('pages.admin-students','successAppoint');
        return $this->successMessage("Berhasil memasukkan siswa ke kelas");
    }catch(\Exception $e){
        return $this->errorMessage("Gagal memasukkan siswa ke kelas");
    }
    }

    public function exportSITI()
    {
        return Excel::download(new StudentsExport(), 'Students_template_import.xlsx');
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
