<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use App\Models\Classes;
use App\Models\Navs\NavAdmin;
use Illuminate\Support\Facades\Validator;

class AdminClasses extends Component
{
    public $model = Classes::class;
    protected $listeners = ['handleUpdateForm', 'handleViewForm'];
    public $currentID;
    public $inputMore;
    public $menu;
    public $validation_errors = [];
    public $allTingkat;
    public $class = [
        "id" => 0,
        "name" => "",
        "tingkat" => "I",
        "is_active" => "",
    ];
    private $rules = [
        'name' => 'required',
        'tingkat' => 'required',
    ];

    private $messages = [
        "name.required" => "Nama tidak boleh kosong",
        "tingkat.required" => "Tingkatan kelas tidak boleh kosong",

    ];
    public function mount()
    {
        $this->menu = NavAdmin::getMenu();
        $this->allTingkat = $this->model::tingkat;
    }
    public function render()
    {
        return view('livewire.pages.admin-classes', ['subMenu' => 'Class']);
    }
    public function handleUpdateForm($class)
    {
        $this->currentID = $class['id'];
        $this->class = $class;
    }
    public function handleViewForm($class)
    {
        $this->class = $class;
    }
    public function emptyForm()
    {
        $this->class = [
            "id" => 0,
            "name" => "",
            "is_active" => "",
            "tingkat" => "",
        ];
    }

    public function create()
    {
        $validator_object = Validator::make($this->class, $this->rules, $this->messages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {
                $query = [
                    'name' => $this->class['name'],
                    'tingkat' => $this->class['tingkat'],
                ];
                $this->model::insert($query);
                $this->emptyForm();
                if (!$this->inputMore)
                    $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-classes-table', 'successMessage', 'Berhasil menambahkan data murid');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-classes-table', 'errorMessage', 'Gagal menambahkan data murid');
            }
            return $this->validation_errors = [];
        }
    }
    public function update()
    {
        $validator_object = Validator::make($this->class, $this->rules, $this->messages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {
                $query = [
                    'name' => $this->class['name'],
                    'tingkat' => $this->class['tingkat'],
                ];

                $this->model::where('id', $this->currentID)->update($query);
                $this->emptyForm();

                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-classes-table', 'successMessage', 'Berhasil memperbarui data Kelas');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('admin-classes-table', 'errorMessage', 'Gagal memperbarui data Kelas');
            }
            return $this->validation_errors = [];
        }
    }
}
