<?php

namespace App\Exports;

use App\Models\KompetensiDasar;
use App\Models\StudentClass;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;

use Illuminate\Support\Facades\DB;

class NilaiExport implements FromView, ShouldAutoSize, WithCalculatedFormulas,WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $course_id, $class_id, $tahun_id, $semester, $ki;

    function __construct($course_id, $class_id, $tahun_id, $semester, $ki) {
            $this->course_id = $course_id;
            $this->class_id = $class_id;
            $this->tahun_id = $tahun_id;
            $this->semester = $semester;
            $this->ki = $ki;
    }


    public function view(): View
    {
        $student_nilai = StudentClass::select('student_class.id','students.name', 'classes.tingkat', 'classes.id as class_id', 'classes.name as class_name')
            ->leftJoin('classes', 'classes.id', '=', 'student_class.class_id')
            ->leftJoin('students', 'students.id', '=', 'student_class.student_id')
            ->where('class_id', $this->class_id)
            ->where('tahun_ajaran_id',$this->tahun_id)->orderBy('students.name')->get();

        foreach($student_nilai as $snilai){
            $snilai->nilai = KompetensiDasar::select(
                'kompetensi_dasar.id',
                'kompetensi_dasar.course_id',
                'kompetensi_dasar.tingkat_kelas',
                'kompetensi_dasar.value',
                'kompetensi_dasar.ki',
                'nilai.id as nilai_id',
                'nilai.student_class_id',
                'nilai.NH',
                'nilai.NUTS',
                'nilai.NUAS'
            )->where('course_id', $this->course_id)
            ->where('tahun_ajaran_id', $this->tahun_id)
            ->where('ki', $this->ki)
            ->where('tingkat_kelas', $snilai->tingkat)->leftjoin('nilai', function ($join) use($snilai) {
                $join->on('kompetensi_dasar.id', '=', 'nilai.kd_id')
                    ->where('nilai.semester', $this->semester)
                    ->where('nilai.student_class_id', $snilai->id);
            })->get()->groupBy('ki');

        }
        // dd($student_nilai);
        return view('exports.nilai', ['student_nilai'=> $student_nilai, 'ki'=>$this->ki]);
    }
    // public function collection()
    // {
    //     return DB::table('student_class')->select('students.name')
    //     ->leftJoin('students', 'students.id', '=', 'student_class.student_id')
    //     ->where('class_id', $this->class_id)
    //     ->where('tahun_ajaran_id',$this->tahun_id)->get();
    //     // return StudentClass::where('class_id', $this->class_id)->where('tahun_ajaran_id',$this->tahun_id)->get();
    // }
    public function title(): string
    {
        return 'KI-' . $this->ki;
    }
}
