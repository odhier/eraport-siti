<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;
use App\Models\Classes;

class ClassSearchBar extends Component
{
    protected $listeners = ['incrementHighlight', '_reset', '_getName'];
    public $query;
    public $querytemp;
    public $classes;
    public $selectedClass;
    public $highlightIndex;

    public function mount()
    {
        $this->_reset();
    }

    public function _reset()
    {
        $this->query = '';
        $this->classes = [];
        $this->highlightIndex = 0;
        $this->selectedClass = [];
    }
    public function resetHighlight()
    {
        $this->highlightIndex = 0;
        if ($this->query == "") {
            $this->_reset();
        }
        return;
    }

    public function _getName($id)
    {
        $this->selectedClass = Classes::findOrFail($id)->toArray();
        $this->query = "Kelas " . $this->selectedClass['tingkat'] . " (" . $this->selectedClass['name'] . ")";
        $this->dispatchBrowserEvent('focusSiswaOut');
        $this->emitUp('setClass', $this->selectedClass);
    }
    public function incrementHighlight()
    {
        if (count($this->classes) > 0) {
            if ($this->highlightIndex === count($this->classes) - 1) {
                $this->highlightIndex = 0;
                return;
            }
            $this->highlightIndex++;
            $this->query = $this->classes[$this->highlightIndex]['name'];
        }
    }

    public function decrementHighlight()
    {
        if (count($this->classes) > 0) {
            if ($this->highlightIndex === 0) {
                $this->highlightIndex = count($this->classes) - 1;
                return;
            }
            $this->highlightIndex--;
            $this->query = $this->classes[$this->highlightIndex]['name'];
        }
    }
    public function tabPressed()
    {
        $this->selectedClass = $this->classes[$this->highlightIndex] ?? null;

        if ($this->selectedClass != null) {
            $this->query = "Kelas " . $this->selectedClass['tingkat'] . " (" . $this->selectedClass['name'] . ")";
            $this->dispatchBrowserEvent('focusSiswaOut');
        } else {
            $this->_reset();
        }
        $this->emitUp('setClass', $this->selectedClass);
    }
    public function selectContact($i = null)
    {
        $this->dispatchBrowserEvent('focusSiswaOut');
        if (!$i)
            $this->selectedClass = $this->classes[$this->highlightIndex] ?? null;
        else
            $this->selectedClass = $this->classes[$i] ?? null;

        $this->query = "Kelas " . $this->selectedClass['tingkat'] . " (" . $this->selectedClass['name'] . ")";


        $this->emitUp('setClass', $this->selectedClass);
    }

    public function updatedQuery()
    {
        $this->classes = Classes::where('name', 'like', '%' . $this->query . '%')->orWhere('tingkat', 'like', '%' . $this->query . '%')
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.partials.class-search-bar');
    }
}
