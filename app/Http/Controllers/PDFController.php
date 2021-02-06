<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\KompetensiDasar;
use App\Models\KompetensiInti;
use App\Models\Message;
use App\Models\MessageKI;
use App\Models\NilaiKI;
use App\Models\Semester;
use App\Models\StudentClass;
use App\Models\TeacherCourse;
use App\Models\WaliKelas;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public $tahun_id;
    public $wali_kelas;
    public $student_class;
    public $courses;
    public $nilaiKi;
    public $kds;
    public function download($tahun_id, $class_id, $semester, $student_class_id)
    {
        $this->tahun_id = $tahun_id;
        $this->wali_kelas = WaliKelas::with('class')->with('user')->with('tahun_ajaran')->find($class_id);
        $this->student_class = StudentClass::select('student_class.*', 'saran.saran')->leftjoin('saran', function ($join) use ($semester) {
            $join->on('student_class.id', '=', 'saran.student_class_id')
                ->where('saran.semester', $semester);
        })->with('student')->with('classes')->find($student_class_id);
        $this->courses = TeacherCourse::with('course')->with('course.kompetensi_dasar')->where('class_id', $this->student_class->class_id)
            ->where('tahun_ajaran_id', $this->student_class->tahun_ajaran_id)->get();
        $data['wali_kelas'] = $this->wali_kelas->toArray();
        $data['student_class'] = $this->student_class->toArray();
        $data['semester'] = $semester;
        $data['semester_name'] = Semester::SEMESTER[$semester];


        $nilaiKi = KompetensiInti::with('ki_detail')->get();
        foreach ($nilaiKi as $nilai) {
            $nilai->nilai_lengkap = true;
            foreach ($nilai->ki_detail as $detail) {
                $n = NilaiKI::select('value')->where('student_class_id', $student_class_id)->where('ki_detail_id', $detail->id)->first();
                $nilai->nilai_lengkap = (!$n || $n->value == 0) ? false : $nilai->nilai_lengkap;
                $detail->value = ($n) ? $n->value : 0;
            }
            $nilai->nilai_akhir = round($nilai->ki_detail->avg('value'));
            $message = MessageKI::where('ki_id', $nilai->id)->where('semester', $semester)->where('student_class_id', $student_class_id)->first();
            $nilai->message = ($message) ? $message->deskripsi : "";
        }
        $this->nilaiKi = $nilaiKi;
        $data['nilaiKi'] = $this->nilaiKi;

        $kds = $this->getKD($this->student_class->classes->tingkat, $this->student_class->tahun_ajaran->id, $semester)->groupBy('course_id');
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
        $data['kds'] = $this->kds;
        $data['absensi'] = Absensi::where('student_class_id', $this->student_class->id)->where('semester', $semester)->first();
        $pdf = PDF::loadView('pdf.template', $data);
        // $pdf->download('invoice.pdf');
        // return view('pdf.tes', $data);
        return $pdf->stream();
    }
    public function getKD($tingkat = null, $tahun = null, $semester)
    {
        return KompetensiDasar::select('kompetensi_dasar.id as kompetensi_id', 'kompetensi_dasar.*', 'nilai.id as nilai_id', 'nilai.*')
            ->when($tingkat, function ($query, $tingkat) {
                return $query->where('tingkat_kelas', $tingkat);
            })->where('tahun_ajaran_id', (!empty($tahun)) ? $tahun : 0)
            ->leftjoin('nilai', function ($join) use ($semester) {
                $join->on('kompetensi_dasar.id', '=', 'nilai.kd_id')
                    ->where('nilai.student_class_id', $this->student_class->id)
                    ->where('nilai.semester', $semester);
            })->with('course')->get()->where('course.is_active', 1);
    }
}
