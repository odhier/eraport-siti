<?php

namespace App\Http\Livewire\Pages;

use App\Models\Course;
use App\Models\KompetensiDasar;
use App\Models\Message;
use App\Models\Semester;
use App\Models\StudentClass;
use App\Models\WaliKelas;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DetailNilaiCourse extends Component
{
    public $wali_kelas;
    public $student_class;
    public $kds;
    public $semester;
    public $course;

    public function mount($course_id, $class_id, $tahun_id, $semester, $student_class_id){
        $this->wali_kelas = WaliKelas::with('class')->with('user')->with('tahun_ajaran')->where('class_id',$class_id)->where('tahun_ajaran_id', $tahun_id)->firstOrFail();
        $this->student_class = StudentClass::with('student')->with('classes')->findorFail($student_class_id);
        $this->semester = ['id' => $semester, 'name' => Semester::SEMESTER[$semester]];
        $this->course = Course::findOrFail($course_id);

        $kds = $this->getKDByCourse($this->student_class->classes->tingkat, $tahun_id, $semester, $course_id)->groupBy('course_id');
        foreach ($kds as $kd) {
            $kd['nilai_terendah_3'] = ($kd->where('ki', 3)->where('NA', $kd->where('ki', 3)->min('NA'))->last());
            $kd['nilai_tertinggi_3'] = ($kd->where('ki', 3)->where('NA', $kd->where('ki', 3)->max('NA'))->first());

            $kd['nilai_terendah_4'] = ($kd->where('ki', 4)->where('NA', $kd->where('ki', 4)->min('NA'))->last());
            $kd['nilai_tertinggi_4'] = ($kd->where('ki', 4)->where('NA', $kd->where('ki', 4)->max('NA'))->first());

            $kd['course'] = $kd[0]->course;
            $nilai_3 = (($kd->where('ki', 3)->sum('NH') * 2) + $kd->where('ki', 3)->sum('NUTS') + $kd->where('ki', 3)->sum('NUAS'));
            $kd['nilai_akhir_3'] = ($nilai_3) ? ($nilai_3 / 4) / count($kd->where('ki', 3)) : 0;
            $nilai_4 = (($kd->where('ki', 4)->sum('NH') * 2) + $kd->where('ki', 4)->sum('NUTS') + $kd->where('ki', 4)->sum('NUAS'));
            $kd['nilai_akhir_4'] = ($nilai_4) ? ($nilai_4 / 4) / count($kd->where('ki', 4)) : 0;

            $kd['predikat_3'] = ($kd['nilai_akhir_3'] >= 93) ? "A" : (($kd['nilai_akhir_3'] >= 86) ? "B" : (($kd['nilai_akhir_3'] >= 80) ? "C" : "D"));
            $kd['predikat_4'] = ($kd['nilai_akhir_4'] >= 93) ? "A" : (($kd['nilai_akhir_4'] >= 86) ? "B" : (($kd['nilai_akhir_4'] >= 80) ? "C" : "D"));

            if ($kd['course']->kode == "UMMI") {
                $msg_3 = Message::select('deskripsi')
                    ->join('teacher_course', 'messages.teacher_course_id', '=', 'teacher_course.id')
                    ->where('student_class_id', $student_class_id)->where('semester', $semester)
                    ->where('ki', 3)->where('teacher_course.course_id', $kd['course']->id)->first();
                $msg_4 = Message::select('deskripsi')
                    ->join('teacher_course', 'messages.teacher_course_id', '=', 'teacher_course.id')
                    ->with('teacher_course')->where('student_class_id', $student_class_id)->where('semester', $semester)
                    ->where('ki', 4)->where('teacher_course.course_id', $kd['course']->id)->first();
                $kd['message_3'] = ($msg_3) ? $msg_3->deskripsi : "";
                $kd['message_4'] = ($msg_4) ? $msg_4->deskripsi : "";
            } else {
                $kd['message_3'] = "Ananda {$this->student_class->student->name} ";
                $kd['message_3'] .= ($kd['nilai_tertinggi_3']->NA > 85) ? "sangat baik" : (($kd['nilai_tertinggi_3']->NA > 70 && $kd['nilai_tertinggi_3']->NA <= 85) ? "sudah baik" : (($kd['nilai_tertinggi_3']->NA > 55 && $kd['nilai_tertinggi_3']->NA <= 70) ? "cukup baik" : "perlu bimbingan"));
                $kd['message_3'] .= " dalam " . trim($kd['nilai_tertinggi_3']->value);

                if ($kd['nilai_tertinggi_3']->kompetensi_id != $kd['nilai_terendah_3']->kompetensi_id) {
                    $kd['message_3'] .= ", dan ";
                    $kd['message_3'] .= ($kd['nilai_terendah_3']->NA > 85) ? "sangat baik" : (($kd['nilai_terendah_3']->NA > 70 && $kd['nilai_terendah_3']->NA <= 85) ? "sudah baik" : (($kd['nilai_terendah_3']->NA > 55 && $kd['nilai_terendah_3']->NA <= 70) ? "cukup baik" : "perlu bimbingan"));
                    $kd['message_3'] .= " dalam " . trim($kd['nilai_terendah_3']->value);
                }

                $kd['message_4'] = "Ananda {$this->student_class->student->name} ";
                $kd['message_4'] .= ($kd['nilai_tertinggi_4']['NA'] > 85) ? "sangat baik" : (($kd['nilai_tertinggi_4']['NA'] > 70 && $kd['nilai_tertinggi_4']['NA'] <= 85) ? "sudah baik" : (($kd['nilai_tertinggi_4']['NA'] > 55 && $kd['nilai_tertinggi_4']['NA'] <= 70) ? "cukup baik" : "perlu bimbingan"));
                $kd['message_4'] .= " dalam " . trim($kd['nilai_tertinggi_4']['value']);


                if ($kd['nilai_tertinggi_4']['kompetensi_id'] != $kd['nilai_terendah_4']['kompetensi_id']) {
                    $kd['message_4'] .= ", dan ";
                    $kd['message_4'] .= ($kd['nilai_terendah_4']['NA'] > 85) ? "sangat baik" : (($kd['nilai_terendah_4']['NA'] > 70 && $kd['nilai_terendah_4']['NA'] <= 85) ? "sudah baik" : (($kd['nilai_terendah_4']['NA'] > 55 && $kd['nilai_terendah_4']['NA'] <= 70) ? "cukup baik" : "perlu bimbingan"));
                    $kd['message_4'] .= " dalam " . trim($kd['nilai_terendah_4']['value']);
                }
            }
        }
        $this->kds = $kds->toArray();
    }
    public function render()
    {
        return view('livewire.pages.detail-nilai-course');
    }
    public function getKDByCourse($tingkat = null, $tahun = null, $semester, $course_id)
    {
        return KompetensiDasar::select(DB::raw('kompetensi_dasar.id as kompetensi_id, kompetensi_dasar.*, nilai.id as nilai_id, nilai.*, ((nilai.NH * 2)+nilai.NUTS+nilai.NUAS)/4 as NA'))
            ->when($tingkat, function ($query, $tingkat) {
                return $query->where('tingkat_kelas', $tingkat);
            })->where('tahun_ajaran_id', (!empty($tahun)) ? $tahun : 0)
            ->where('course_id', $course_id)
            ->leftjoin('nilai', function ($join) use ($semester) {
                $join->on('kompetensi_dasar.id', '=', 'nilai.kd_id')
                    ->where('nilai.student_class_id', $this->student_class->id)
                    ->where('nilai.semester', $semester);
            })->with('course')->get()->where('course.is_active', 1);
    }
}
