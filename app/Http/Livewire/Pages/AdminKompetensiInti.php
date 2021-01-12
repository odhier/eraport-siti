<?php

namespace App\Http\Livewire\Pages;

use App\Models\KompetensiInti;
use App\Models\KompetensiIntiDetail;
use App\Models\Navs\NavAdmin;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class AdminKompetensiInti extends Component
{
    protected $listeners = ['editForm'];
    public $model = KompetensiInti::class;
    public $subMenu = "Kompetensi Inti";
    public $menu;
    public $inputMore;
    public $validation_errors = [];
    public $all_ki = [''];
    public $current_ki = ['kode' => '', 'name' => ''];
    public $ki = [
        "name" => "",
        "kode" => "",
    ];
    private $customrules = [
        'name' => 'required',
        'kode' => 'required',
    ];

    private $custommessages = [
        "name.required" => "Nama Kompetensi tidak boleh kosong",
        "kode.required" => "Kode Kompetensi tidak boleh kosong",

    ];

    public $deleteLists = [];

    public function mount()
    {
        $this->menu = NavAdmin::getMenu();
    }
    public function render()
    {
        return view('livewire.pages.admin-kompetensi-inti');
    }
    public function create()
    {
        $validator_object = Validator::make($this->ki, $this->customrules, $this->custommessages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {
                $query = [
                    'name' => $this->ki['name'],
                    'kode' => $this->ki['kode'],
                ];
                $this->model::insert($query);
                $this->emptyForm();
                if (!$this->inputMore)
                    $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-kompetensi-inti-table', 'successMessage', 'Berhasil menambahkan data Kompetensi Inti');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-kompetensi-inti-table', 'errorMessage', 'Gagal menambahkan data Kompetensi Inti');
            }
            return $this->validation_errors = [];
        }
    }
    public function save()
    {
        try {
            $kds = array_filter($this->all_ki);
            foreach ($kds as $kd) {
                $query = [
                    'ki_id' => $this->current_ki['id'],
                    'kompetensi' => $kd['kompetensi'],
                ];

                if (isset($kd['id'])) {
                    $query["updated_at"] = \Carbon\Carbon::now();
                    KompetensiIntiDetail::where('id', $kd['id'])
                        ->update($query);
                } else {
                    $query["created_at"] = \Carbon\Carbon::now();

                    KompetensiIntiDetail::insert($query);
                }
            }
            //end insert or update kompetensi dasar

            //menghapus kompetensi dasar
            if ($this->deleteLists) {
                KompetensiIntiDetail::destroy($this->deleteLists);
            }

            $this->emptyForm();
            $this->dispatchBrowserEvent('closeModal');
            $this->emitTo('admin-kompetensi-inti-table', 'successMessage', 'Berhasil memperbarui data Kompetensi Inti');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('closeModal');
            $this->emitTo('admin-kompetensi-inti-table', 'errorMessage', 'Gagal memperbarui data Kompetensi Inti');
        }
        $this->validation_errors = [];
    }
    public function emptyForm()
    {
        $this->ki = [
            "name" => "",
            "kode" => "",
        ];
    }
    public function editForm($id)
    {

        $this->deleteLists = [];
        $ki = $this->model::find($id);
        if ($ki) {
            $this->current_ki = $ki->toArray();
            $all_ki = $this->getKI($id);
            $this->all_ki = ($all_ki->toArray()) ? [] : [''];
            foreach ($all_ki as $ki) {
                $this->all_ki[] = ['id' => $ki->id, 'kompetensi' => $ki->kompetensi];
            }
        } else {
            $this->dispatchBrowserEvent('closeModal');
            $this->emitTo('admin-kompetensi-inti-table', 'errorMessage', 'ID Kompetensi Inti tidak ditemukan');
        }
    }
    public function getKI($id)
    {
        return KompetensiIntiDetail::where('ki_id', $id)->get();
    }
    public function addKI()
    {
        $this->all_ki[] = '';
        $this->dispatchBrowserEvent('focusLast', ['id' => 'inputKd-' . count($this->all_ki)]);
    }
    public function removeKI($index, $id)
    {
        if ($id > 0)
            $this->deleteLists[] = $id;
        unset($this->all_ki[$index]);
    }
}
