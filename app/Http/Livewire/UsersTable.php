<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

use Illuminate\Support\Facades\Auth;



class UsersTable extends LivewireDatatable
{
    protected $listeners = ['confirmDelete', '_delete', 'successMessage', 'errorMessage', 'editForm'];

    public $addable = true;
    public $model = User::class;
    public $_id;

    public function builder()
    {
        return User::query()->leftJoin('roles', 'roles.id', 'users.role_id');
    }

    public function confirmDelete($id)
    {
        $this->_id = $id;
    }

    public function _delete()
    {
        $_user = User::findOrFail($this->_id);

        if ($_user->role_id > Auth::user()->role_id) {
            $this->delete($this->_id);
            $this->successMessage('User berhasil dihapus');
        } else {
            $this->errorMessage(Auth::user()->role->name . ' tidak bisa menghapus ' . $_user->role->name);
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
    public function editForm($id)
    {
        $user = User::find($id)->toArray();
        $this->emitUp('handleFormEdit', $user);
    }
    public function viewForm($id)
    {
        $user = User::find($id)->toArray();
        $this->emitUp('handleFormView', $user);
    }

    public function columns()
    {
        return [
            NumberColumn::name('users.id')
                ->label('ID')
                ->sortBy('users.id'),
            Column::callback(['picture', 'name'], function ($picture, $name) {
                return view('livewire.datatables.picture', ['picture' => $picture, 'name' => $name]);
            })->label('Picture'),

            Column::name('users.name')
                ->label('Name')->editable(),

            Column::name('email'),

            Column::name('roles.name')->label('Role'),
            BooleanColumn::name('is_active')
                ->label('Active')->editable(),
            Column::callback(['id', 'name', 'role_id'], function ($id, $name, $role_id) {
                return view('livewire.datatables.table-actions', ['id' => $id, 'name' => $name, 'role' => $role_id]);
            })->label('Actions')
        ];
    }
}
