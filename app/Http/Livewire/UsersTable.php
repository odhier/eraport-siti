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
                // return view('livewire.datatables.table-actions', ['id' => $id, 'name' => $name, 'role' => $role_id]);
                return '<div class="flex space-x-1 justify-around">
                <a data-toggle="modal" data-target="#viewModal" wire:click="$emitTo(\'pages.admin\',\'viewForm\',\'' . $id . '\')" class="p-1 text-teal-600 hover:bg-teal-600 hover:text-white rounded">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                </a>
                <a data-toggle="modal" data-target="#editModal" wire:click="editForm(' . $id . ')" class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
                </a>

                <button data-toggle="modal" data-target="#deleteModal" wire:click="confirmDelete(' . $id . ')" class="p-1 text-red-600 hover:bg-red-600 hover:text-white rounded">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                </button>


            </div>';
            })->label('Actions')
        ];
    }
}
