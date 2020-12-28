<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;
use App\Models\Course;

class CourseSearchBar extends Component
{
    protected $listeners = ['incrementHighlight', '_reset', '_getName'];
    public $query;
    public $querytemp;
    public $courses;
    public $selectedCourse;
    public $highlightIndex;

    public function mount()
    {
        $this->_reset();
    }

    public function _reset()
    {
        $this->query = '';
        $this->courses = [];
        $this->highlightIndex = 0;
        $this->selectedCourse = [];
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
        $this->selectedCourse = Course::findOrFail($id)->toArray();
        $this->query = $this->selectedCourse['name'];
        $this->dispatchBrowserEvent('focusSiswaOut');
        $this->emitUp('setCourse', $this->selectedCourse);
    }
    public function incrementHighlight()
    {
        if (count($this->courses) > 0) {
            if ($this->highlightIndex === count($this->courses) - 1) {
                $this->highlightIndex = 0;
                return;
            }
            $this->highlightIndex++;
            $this->query = $this->courses[$this->highlightIndex]['name'];
        }
    }

    public function decrementHighlight()
    {
        if (count($this->courses) > 0) {
            if ($this->highlightIndex === 0) {
                $this->highlightIndex = count($this->courses) - 1;
                return;
            }
            $this->highlightIndex--;
            $this->query = $this->courses[$this->highlightIndex]['name'];
        }
    }
    public function tabPressed()
    {
        $this->selectedCourse = $this->courses[$this->highlightIndex] ?? null;

        if ($this->selectedCourse != null) {
            $this->query = $this->selectedCourse['name'];
            $this->dispatchBrowserEvent('focusSiswaOut');
        } else {
            $this->_reset();
        }
        $this->emitUp('setCourse', $this->selectedCourse);
    }
    public function selectContact($i = null)
    {
        $this->dispatchBrowserEvent('focusSiswaOut');
        if (!$i)
            $this->selectedCourse = $this->courses[$this->highlightIndex] ?? null;
        else
            $this->selectedCourse = $this->courses[$i] ?? null;

        $this->query = $this->selectedCourse['name'];


        $this->emitUp('setCourse', $this->selectedCourse);
    }

    public function updatedQuery()
    {
        $this->courses = Course::where('name', 'like', '%' . $this->query . '%')->orWhere('kode', 'like', '%' . $this->query . '%')
            ->get()
            ->toArray();
    }
    public function render()
    {
        return view('livewire.partials.course-search-bar');
    }
}
