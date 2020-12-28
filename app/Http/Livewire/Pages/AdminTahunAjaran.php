<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use App\Models\TahunAjaran;
use App\Models\Navs\NavAdmin;
use Illuminate\Support\Facades\Validator;

class AdminTahunAjaran extends Component
{
    public $model = TahunAjaran::class;
    protected $listeners = ['handleUpdateForm', 'handleViewForm'];
    public $currentID;
    public $inputMore;
    public $menu;
    public $validation_errors = [];
    public $tahun = [
        "id" => 0,
        "tahun_ajaran" => "",
    ];
    private $rules = [
        'tahun_ajaran' => 'required',
    ];

    private $messages = [
        "tahun_ajaran.required" => "Tahun ajaran tidak boleh kosong",
    ];

    public function mount()
    {
        $this->menu = NavAdmin::getMenu();
    }
    public function render()
    {
        return view('livewire.pages.admin-tahun-ajaran', ['subMenu' => 'Tahun Ajaran']);
    }
    public function handleUpdateForm($tahun)
    {
        $this->currentID = $tahun['id'];
        $this->tahun = $tahun;
    }
    public function handleViewForm($tahun)
    {
        $this->tahun = $tahun;
    }
    public function emptyForm()
    {
        $this->tahun = [
            "id" => 0,
            "tahun_ajaran" => "",
        ];
    }
    public function create()
    {

        $validator_object = Validator::make($this->tahun, $this->rules, $this->messages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {
                $query = [
                    'tahun_ajaran' => $this->tahun['tahun_ajaran'],
                ];
                $this->model::insert($query);
                $this->emptyForm();
                if (!$this->inputMore)
                    $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-tahun-ajaran-table', 'successMessage', 'Berhasil menambahkan data murid');
            } catch (\Exception $e) {
                dd($e);
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-tahun-ajaran-table', 'errorMessage', 'Gagal menambahkan data murid');
            }
            return $this->validation_errors = [];
        }
    }
    public function update()
    {
        $validator_object = Validator::make($this->tahun, $this->rules, $this->messages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {
                $query = [
                    'tahun_ajaran' => $this->tahun['tahun_ajaran'],
                ];

                $this->model::where('id', $this->currentID)->update($query);
                $this->emptyForm();

                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-tahun-ajaran-table', 'successMessage', 'Berhasil memperbarui tahun ajaran');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-tahun-ajaran-table', 'errorMessage', 'Gagal memperbarui tahun ajaran');
            }
            return $this->validation_errors = [];
        }
    }
}
