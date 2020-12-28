<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;
use App\Models\User;

class TeacherSearchBar extends Component
{
    protected $listeners = ['incrementHighlight', '_getName', '_reset'];
    public $query;
    public $querytemp;
    public $teachers;
    public $selectedTeacher;
    public $highlightIndex;

    public function mount()
    {
        $this->_reset();
    }

    public function _reset()
    {
        $this->query = '';
        $this->teachers = [];
        $this->highlightIndex = 0;
        $this->selectedTeacher = [];
    }
    public function resetHighlight()
    {
        $this->highlightIndex = 0;
        return;
    }
    public function _getName($id)
    {
        $this->selectedTeacher = User::findOrFail($id)->toArray();
        $this->query = $this->selectedTeacher['name'];
        $this->dispatchBrowserEvent('focusSiswaOut');
        $this->emitUp('setTeacher', $this->selectedTeacher);
    }

    public function incrementHighlight()
    {
        if (count($this->teachers) > 0) {
            if ($this->highlightIndex === count($this->teachers) - 1) {
                $this->highlightIndex = 0;
                return;
            }
            $this->highlightIndex++;
            $this->query = $this->teachers[$this->highlightIndex]['name'];
        }
    }

    public function decrementHighlight()
    {
        if (count($this->teachers) > 0) {
            if ($this->highlightIndex === 0) {
                $this->highlightIndex = count($this->teachers) - 1;
                return;
            }
            $this->highlightIndex--;
            $this->query = $this->teachers[$this->highlightIndex]['name'];
        }
    }
    public function tabPressed()
    {
        $this->selectedTeacher = $this->teachers[$this->highlightIndex] ?? null;

        if ($this->selectedTeacher != null) {
            $this->query = $this->selectedTeacher['name'];
            $this->dispatchBrowserEvent('focusSiswaOut');
        } else {
            $this->_reset();
        }
        $this->emitUp('setTeacher', $this->selectedTeacher);
    }
    public function selectContact($i = null)
    {
        $this->dispatchBrowserEvent('focusSiswaOut');
        if (!$i)
            $this->selectedTeacher = $this->teachers[$this->highlightIndex] ?? null;
        else
            $this->selectedTeacher = $this->teachers[$i] ?? null;
        $this->query = $this->selectedTeacher['name'];
        $this->emitUp('setTeacher', $this->selectedTeacher);
    }

    public function updatedQuery()
    {
        // $this->query = $this->querytemp;
        $this->teachers = User::where('name', 'like', '%' . $this->query . '%')
            ->where('role_id', '3')
            ->get()
            ->toArray();
    }
    public function render()
    {
        return view('livewire.partials.teacher-search-bar');
    }
}
