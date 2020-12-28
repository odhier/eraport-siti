<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;
use App\Models\Student;

use function PHPUnit\Framework\isNull;

class StudentSearchBar extends Component
{
    protected $listeners = ['incrementHighlight', '_getName', '_reset'];
    public $query;
    public $querytemp;
    public $students;
    public $selectedStudent;
    public $highlightIndex;

    public function mount()
    {
        $this->_reset();
    }

    public function _reset()
    {
        $this->query = '';
        $this->students = [];
        $this->highlightIndex = 0;
        $this->selectedStudent = [];
    }
    public function resetHighlight()
    {
        $this->highlightIndex = 0;
        return;
    }
    public function _getName($id)
    {
        $this->selectedStudent = Student::findOrFail($id)->toArray();
        $this->query = $this->selectedStudent['name'];
        $this->dispatchBrowserEvent('focusSiswaOut');
        $this->emitUp('setStudent', $this->selectedStudent);
    }

    public function incrementHighlight()
    {
        if (count($this->students) > 0) {
            if ($this->highlightIndex === count($this->students) - 1) {
                $this->highlightIndex = 0;
                return;
            }
            $this->highlightIndex++;
            $this->query = $this->students[$this->highlightIndex]['name'];
        }
    }

    public function decrementHighlight()
    {
        if (count($this->students) > 0) {
            if ($this->highlightIndex === 0) {
                $this->highlightIndex = count($this->students) - 1;
                return;
            }
            $this->highlightIndex--;
            $this->query = $this->students[$this->highlightIndex]['name'];
        }
    }
    public function tabPressed()
    {
        $this->selectedStudent = $this->students[$this->highlightIndex] ?? null;

        if ($this->selectedStudent != null) {
            $this->query = $this->selectedStudent['name'];
            $this->dispatchBrowserEvent('focusSiswaOut');
        } else {
            $this->_reset();
        }
        $this->emitUp('setStudent', $this->selectedStudent);
    }
    public function selectContact($i = null)
    {

        $this->dispatchBrowserEvent('focusSiswaOut');
        if (!$i) {
            $this->selectedStudent = $this->students[$this->highlightIndex] ?? null;
            $this->query = $this->selectedStudent['name'];
        } else {
            $this->selectedStudent = $this->students[$i] ?? null;
            $this->query = $this->selectedStudent['name'];
        }
        $this->emitUp('setStudent', $this->selectedStudent);
    }


    public function updatedQuery()
    {
        // $this->query = $this->querytemp;
        $this->students = Student::where('name', 'like', '%' . $this->query . '%')
            ->get()
            ->toArray();
    }
    public function render()
    {
        return view('livewire.partials.student-search-bar');
    }
}
