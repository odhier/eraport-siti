<?php

namespace App\Http\Livewire\Partials\Modals;

use App\Models\Ekstrakurikuler as ModelsEkstrakurikuler;
use App\Models\EkstrakurikulerDetail;
use App\Models\Semester;
use App\Models\StudentClass;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Ekstrakurikuler extends Component
{
    public $validation_errors;
    public $semester, $student_class, $ekstrakurikuler;
    public $deleteLists;
    protected $listeners = ['open' => 'loadForm'];
    protected $rules = [
        '*.name' => 'required',
        '*.nilai' => 'required',
    ];
    protected $messages = [
        "*.name.required" => "Name Kegiatan tidak boleh kosong",
        "*.nilai.required" => "Nilai tidak boleh kosong",
    ];

    public function loadForm($id, $semester){
        $this->validation_errors = [];
        $this->semester= ['id'=>$semester, 'name'=>Semester::SEMESTER[$semester]];
        $this->student_class = StudentClass::with('student')->findOrFail($id);
        $this->ekstrakurikuler = ModelsEkstrakurikuler::with('detail')->firstOrCreate([
            'student_class_id' => $this->student_class->id,
            'semester' => $semester
        ])->toArray();
        if(!isset($this->ekstrakurikuler['detail']) || !count($this->ekstrakurikuler['detail'])){
            $this->ekstrakurikuler['detail'][] = ['name'=>'', 'nilai'=>'', 'keterangan'=>''];
        }
        return $this->emit('toggleLoading');
    }
    public function addDetail()
    {
        $this->ekstrakurikuler['detail'][] = '';
        // $this->dispatchBrowserEvent('focusLast', ['id' => 'inputKd-' . count($this->kds)]);
    }
    public function removeDetail($index){
        if(isset($this->ekstrakurikuler['detail'][$index]['id'])) $this->deleteLists[] = $this->ekstrakurikuler['detail'][$index]['id'];
        unset($this->ekstrakurikuler['detail'][$index]);
    }
    public function save(){
        try{
            if($this->deleteLists) EkstrakurikulerDetail::destroy($this->deleteLists);
            foreach($this->ekstrakurikuler['detail'] as $detail){
                    $validator_object = Validator::make($this->ekstrakurikuler['detail'], $this->rules, $this->messages);
                    if ($validator_object->fails()) {
                        $this->emit('toggleSaving');
                        return $this->validation_errors = $validator_object->errors()->toArray();
                    } else {
                        if(isset($detail['id'])){
                            EkstrakurikulerDetail::where('id', $detail['id'])->update(['name' => $detail['name'], 'nilai' => $detail['nilai'], 'keterangan' => $detail['keterangan']]);
                        }else{
                            EkstrakurikulerDetail::insert([
                                'ekstrakurikuler_id' => $this->ekstrakurikuler['id'],
                                'name' => $detail['name'],
                                'nilai' => $detail['nilai'],
                                'keterangan' => isset($detail['keterangan'])?$detail['keterangan']:""
                            ]);
                        }
                }
            }
            $this->dispatchBrowserEvent('closeModal');
            $this->emitTo('class-table', 'successMessage', 'Berhasil menyimpan data');
        } catch(\Exception $e){
            dd($e);
            $this->dispatchBrowserEvent('closeModal');
            $this->emit('toggleSaving');
            return $this->emitTo('class-table', 'errorMessage', 'Gagal input Ekstrakurikuler Siswa');
        }
        $this->emit('toggleSaving');
        return $this->validation_errors = [];
        // dd($this->ekstrakurikuler);
    }
    public function render()
    {
        return view('livewire.partials.modals.ekstrakurikuler');
    }
}
