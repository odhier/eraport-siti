<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class StudentsExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        return view('exports.students');
    }
}
