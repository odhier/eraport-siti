<?php

namespace App\Http\Livewire\Partials\Modals;

use App\Models\Semester;
use App\Models\StudentClass;
use App\Models\Physique as physiqueModel;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Physique extends Component
{
    public $angka=1;
    public $student_class;
    public $semester;
    public $physique;
    public $validation_errors;
    protected $listeners = ['open' => 'loadForm'];
    protected $rules = [
        'tinggi' => 'numeric',
        'berat' => 'numeric',
        'pendengaran' => 'in:"Baik","Tidak Baik",""',
        'penglihatan' => 'in:"Baik","Tidak Baik",""',
        'gigi' => 'in:"Bersih","Tidak Bersih",""',
    ];
    protected $messages = [
        "*.numeric" => "Hanya boleh angka",
        "*.in" => "Value tidak valid"
    ];
    public function loadForm($id, $semester){
        $this->validation_errors = [];
        $this->semester= ['id'=>$semester, 'name'=>Semester::SEMESTER[$semester]];
        $this->student_class = StudentClass::with('student')->findOrFail($id);
        $this->physique = physiqueModel::firstOrCreate([
            'student_class_id' => $this->student_class->id,
            'semester' => $semester
        ])->toArray();

        return $this->emit('toggleLoading');
    }
    public function save(){
        if(!$this->physique || !$this->physique['student_class_id']) {
            $this->dispatchBrowserEvent('closeModal');
            $this->emit('toggleSaving');
            return $this->emitTo('class-table', 'errorMessage', 'Gagal input Fisik & Kondisi Kesehatan Siswa');
        }
        $validator_object = Validator::make($this->physique, $this->rules, $this->messages);
        if ($validator_object->fails()) {
            $this->emit('toggleSaving');
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try{
                physiqueModel::updateOrCreate(
                    ['student_class_id' => $this->physique['student_class_id'], 'semester' => $this->semester['id']],
                    [
                        'tinggi' => $this->physique['tinggi'],
                        'berat' => $this->physique['berat'],
                        'pendengaran'=> $this->physique['pendengaran'],
                        'penglihatan' => $this->physique['penglihatan'],
                        'gigi' => $this->physique['gigi']
                    ]
                );
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('class-table', 'successMessage', 'Berhasil menyimpan data');
            }catch(\Exception $e){
                $this->dispatchBrowserEvent('closeModal');
                $this->emit('toggleSaving');
                return $this->emitTo('class-table', 'errorMessage', 'Gagal input Fisik & Kondisi Kesehatan Siswa');
            }

            $this->emit('toggleSaving');
            return $this->validation_errors = [];
        }
    }
    public function render()
    {
        return view('livewire.partials.modals.physique');
    }
}
