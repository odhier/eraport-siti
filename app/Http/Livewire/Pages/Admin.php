<?php

namespace App\Http\Livewire\Pages;

use App\Models\Navs\NavAdmin;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;


class Admin extends Component
{
    protected $listeners = ['editForm', 'viewForm', 'editFormParaf'];
    use WithFileUploads;

    public $currentIDUser;
    public $loadData = false;
    public $changeRole = false;
    public $inputMore;
    public $allRoles;
    public $menu;
    public $user = [
        "id" => 0,
        "user_type" => 3,
        "name" => "",
        "email" => "",
        "picture" => "",
        "picture_paraf" => "",
        "NIP" => "",
        "password" => "",
        "confirm_password" => "",
        "current_picture" => "",
        "current_picture_paraf" => "",
        "is_active" => "",
        "role_name" => "",
    ];
    public $remove_pic = false;
    public $remove_pic_paraf = false;
    public $validation_errors = [];

    public function mount()
    {
        $this->menu = NavAdmin::getMenu();
        $this->allRoles = Role::where('id', '>=', Auth::user()->role_id)->pluck('name', 'id');
    }

    public function render()
    {
        return view('livewire.pages.admin', ['subMenu' => 'Users/Teachers']);
    }

    public function emptyUserForm()
    {
        $this->user = [
            "id" => 0,
            "user_type" => 3,
            "name" => "",
            "email" => "",
            "picture" => "",
            "picture_paraf" => "",
            "NIP" => "",
            "password" => "",
            "confirm_password" => "",
            "current_picture" => "",
            "current_picture_paraf" => "",
            "is_active" => "",
            "role_name" => "",
        ];
        $this->currentIDUser = "";
        $this->changeRole = false;
    }
    public function clearPicture()
    {
        $this->user['current_picture'] = "";
        $this->user['picture'] = "";
        $this->remove_pic = true;
    }
    public function clearPictureParaf()
    {
        $this->user['current_picture_paraf'] = "";
        $this->user['picture_paraf'] = "";
        $this->remove_pic_paraf = true;
    }

    public function save()
    {
        $rules = [
            'name' => 'required',
            'NIP' => 'nullable',
            'email' => 'required|email|unique:users,email,',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'picture' => 'image|max:10240',
        ];

        $messages = [
            "name.required" => "Nama tidak boleh kosong",
            "email.required" => "Email tidak boleh kosong",
            "email.email" => "Harap masukkan email yang valid",
            "email.unique" => "Email telah digunakan",
            "password.required" => "Password tidak boleh kosong",
            "password.min" => "Password minimal 8 karakter",
            "confirm_password.required" => "Konfirmasi password tidak boleh kosong",
            "confirm_password.same" => "Konfirmasi password harus sama",
            "picture.image" => "File yang anda masukkan bukan JPG/PNG",
            "picture.max" => "File gambar terlalu besar | Max 10Mb"
        ];

        $validator_object = Validator::make($this->user, $rules, $messages);

        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {

                $query = [
                    'name' => $this->user['name'],
                    'email' => $this->user['email'],
                    'password' => bcrypt($this->user['password']),
                    'NIP' => $this->user['NIP'],
                    'role_id' => $this->user['user_type'],
                ];

                if ($this->user['picture']) {
                    $imageName = $this->user['picture']->store("images", 'public');
                    $query = array_merge($query, ['picture' => $imageName]);
                }

                if ($this->remove_pic && $this->user['picture'] == "") {
                    $query['picture'] = "";
                }

                User::insert($query);
                $this->emptyUserForm();
                if (!$this->inputMore)
                    $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('users-table', 'successMessage', 'User berhasil ditambahkan.');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('users-table', 'errorMessage', 'Gagal menambah user');
            }
            return $this->validation_errors = [];
        }
    }
    public function _updateParaf()
    {
        $rulesEdit = [
            'picture_paraf' => 'image|max:10240',
        ];
        $messages = [
            "picture_paraf.image" => "File yang anda masukkan bukan JPG/PNG",
            "picture_paraf.max" => "File gambar terlalu besar | Max 10Mb"
        ];
        $validator_object = Validator::make($this->user, $rulesEdit, $messages);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {


                if ($this->remove_pic_paraf && $this->user['picture_paraf'] == "") {
                    $query['paraf_img'] = "";
                } else {
                    $imageName = $this->user['picture_paraf']->store("images", 'public');
                    $query['paraf_img'] =  $imageName;
                }

                User::where('id', $this->currentIDUser)->update($query);

                $this->emptyUserForm();
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('users-table', 'successMessage', 'User berhasil diperbarui.');

                return $this->validation_errors = [];
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('users-table', 'errorMessage', 'Gagal memperbarui user');
            }
            return $this->validation_errors = [];
        }
    }
    public function _update()
    {

        $rulesEdit = [
            'name' => 'required',
            'NIP' => 'nullable',
            'email' => 'required|email|unique:users,email,' . $this->currentIDUser,
            'picture' => 'image|max:10240',
        ];
        $messages = [
            "name.required" => "Nama tidak boleh kosong",
            "email.required" => "Email tidak boleh kosong",
            "email.email" => "Harap masukkan email yang valid",
            "email.unique" => "Email telah digunakan",
            "picture.image" => "File yang anda masukkan bukan JPG/PNG",
            "picture.max" => "File gambar terlalu besar | Max 10Mb"
        ];
        $validator_object = Validator::make($this->user, $rulesEdit, $messages);


        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {
                $query = [
                    'name' => $this->user['name'],
                    'email' => $this->user['email'],
                    'NIP' => $this->user['NIP'],
                ];
                if ($this->user['picture']) {
                    $imageName = $this->user['picture']->store("images", 'public');
                    $query = array_merge($query, ['picture' => $imageName]);
                }
                if ($this->changeRole) {
                    $query = array_merge($query, ['role_id' => $this->user['user_type']]);
                }

                if ($this->remove_pic && $this->user['picture'] == "") {
                    $query['picture'] = "";
                }

                User::where('id', $this->currentIDUser)->update($query);

                $this->emptyUserForm();
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('users-table', 'successMessage', 'User berhasil diperbarui.');

                return $this->validation_errors = [];
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emitTo('users-table', 'errorMessage', 'Gagal memperbarui user');
            }
            return $this->validation_errors = [];
        }
    }

    public function editForm($id)
    {
        $_user = User::find($id)->toArray();
        if (Auth::user()->role_id <= $_user['role_id']) {
            $this->remove_pic = false;
            $this->currentIDUser = $_user['id'];
            $this->user = $_user;
            $this->user['user_type'] = $_user['role_id'];
            $this->user['current_picture'] = ($_user["picture"]) ? $_user["picture"] : "";
            $this->user['picture'] = "";
            $this->user['current_picture_paraf'] = ($_user["paraf_img"]) ? $_user["paraf_img"] : "";
            $this->user['picture_paraf'] = "";
            $this->user['role_name'] = Role::findOrFail($_user['role_id'])->name;
        } else {
            $this->dispatchBrowserEvent('closeModal');
            $this->emitTo('users-table', 'errorMessage', 'Anda tidak bisa mengedit Superuser');
        }
    }
    public function viewForm($id)
    {
        $this->loadData = true;
        $_user = User::find($id)->toArray();
        $this->currentIDUser = $_user['id'];
        $this->user = $_user;

        $this->user['current_picture'] = ($_user["picture"]) ? $_user["picture"] : "";
        $this->user['picture'] = "";

        $this->user['current_picture_paraf'] = ($_user["paraf_img"]) ? $_user["paraf_img"] : "";
        $this->user['picture_paraf'] = "";

        $this->user['role_name'] = Role::findOrFail($_user['role_id'])->name;
        $this->loadData = false;
    }
}
