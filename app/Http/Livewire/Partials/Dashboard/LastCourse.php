<?php

namespace App\Http\Livewire\Partials\Dashboard;

use App\Models\LastCourse as ModelsLastCourse;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LastCourse extends Component
{
    private $model = ModelsLastCourse::class;
    public $last_courses;

    public function mount()
    {
        $this->last_courses = $this->model::where('teacher_id', Auth::user()->id)->orderBy('id', 'desc')->with('teacher_course')->get()->unique('teacher_course_id');
    }
    public function render()
    {
        return view('livewire.partials.dashboard.last-course');
    }
}
