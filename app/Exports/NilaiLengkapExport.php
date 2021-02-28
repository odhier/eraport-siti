<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class NilaiLengkapExport implements WithMultipleSheets
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $course_id, $class_id, $tahun_id, $semester;

    function __construct($course_id, $class_id, $tahun_id, $semester) {
            $this->course_id = $course_id;
            $this->class_id = $class_id;
            $this->tahun_id = $tahun_id;
            $this->semester = $semester;
    }
    public function sheets(): array
    {
        $sheets = [];

        for ($ki=3; $ki<=4; $ki++) {
            $sheets[] = new NilaiExport($this->course_id, $this->class_id, $this->tahun_id, $this->semester, $ki);
        }

        return $sheets;
    }
}
