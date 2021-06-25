<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Classes;
use App\Models\KKM;
use App\Models\KompetensiDasar;
use App\Models\KompetensiInti;
use App\Models\Message;
use App\Models\MessageKI;
use App\Models\NilaiKI;
use App\Models\Semester;
use App\Models\StudentClass;
use App\Models\TahunAjaran;
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
            // $k = [];
            // foreach ($nilai->ki_detail as $detail) {
            //     $n = NilaiKI::select('value')->where('student_class_id', $student_class_id)->where('ki_detail_id', $detail->id)->first();
            //     $nilai->nilai_lengkap = (!$n || $n->value == 0) ? false : $nilai->nilai_lengkap;
            //     $detail->value = ($n) ? $n->value : 0;
            //     $k[] = $detail->kompetensi;
            // }

            $nilai->nilai_akhir = round($nilai->ki_detail->avg('value'));
            $nilai->terendah = $nilai->ki_detail->where('value', $nilai->ki_detail->min('value'))->last();
            $nilai->tertinggi = $nilai->ki_detail->where('value', $nilai->ki_detail->min('value'))->last();


            $nilai->message = "Ananda {$this->student_class->student->name} ";
            $nilai->message .= ($nilai->tertinggi->value == 4) ? "sangat baik" : (($nilai->tertinggi->value == 3 ? "sudah baik" : (($nilai->tertinggi->value == 2) ? "cukup baik" : "perlu bimbingan")));
            $nilai->message .= " dalam " . $nilai->tertinggi->kompetensi. ", dan ";

            $nilai->message .= ($nilai->terendah->value == 4) ? "sangat baik" : (($nilai->terendah->value == 3 ? "sudah baik" : (($nilai->terendah->value == 2) ? "cukup baik" : "perlu bimbingan")));
            $nilai->message .= " dalam " . $nilai->terendah->kompetensi;
        }
        $this->nilaiKi = $nilaiKi;
        $data['nilaiKi'] = $this->nilaiKi;

        $kds = $this->getKD($this->student_class->classes->tingkat, $this->student_class->tahun_ajaran->id, $semester)->groupBy('course_id');
        $i = 0;
        try{
        foreach ($kds as $kd) {
            $kd['count_ki3'] = count($kd->where('ki', 3));
            $kd['count_ki4'] = count($kd->where('ki', 4));
            $kd['nilai_terendah_3'] = ($kd->where('ki', 3)->where('NA', $kd->where('ki', 3)->min('NA'))->last());
            $kd['nilai_tertinggi_3'] = ($kd->where('ki', 3)->where('NA', $kd->where('ki', 3)->max('NA'))->first());
            if($kd['nilai_terendah_3'] && $kd['nilai_tertinggi_3']){
            $kd['nilai_tertinggi_3']->NA = (($kd['nilai_tertinggi_3']->NH * 2)+$kd['nilai_tertinggi_3']->NUTS+$kd['nilai_tertinggi_3']->NUAS)/4;
            $kd['nilai_terendah_3']->NA = (($kd['nilai_terendah_3']->NH * 2)+$kd['nilai_terendah_3']->NUTS+$kd['nilai_terendah_3']->NUAS)/4;
            }
            $kd['nilai_terendah_4'] = ($kd->where('ki', 4)->where('NA', $kd->where('ki', 4)->min('NA'))->last());
            $kd['nilai_tertinggi_4'] = ($kd->where('ki', 4)->where('NA', $kd->where('ki', 4)->max('NA'))->first());
            if($kd['nilai_terendah_4'] && $kd['nilai_tertinggi_4']){
                $kd['nilai_tertinggi_4']->NA = (($kd['nilai_tertinggi_4']->NH * 2)+$kd['nilai_tertinggi_4']->NUTS+$kd['nilai_tertinggi_4']->NUAS)/4;
                $kd['nilai_terendah_4']->NA = (($kd['nilai_terendah_4']->NH * 2)+$kd['nilai_terendah_4']->NUTS+$kd['nilai_terendah_4']->NUAS)/4;
            }


            $kd['course'] = $kd[0]->course;
            $nilai_3 = (($kd->where('ki', 3)->sum('NH') * 2) + $kd->where('ki', 3)->sum('NUTS') + $kd->where('ki', 3)->sum('NUAS'));
            $kd['nilai_akhir_3'] = ($nilai_3) ? ($nilai_3 / 4) / $kd['count_ki3'] : 0;
            $nilai_4 = (($kd->where('ki', 4)->sum('NH') * 2) + $kd->where('ki', 4)->sum('NUTS') + $kd->where('ki', 4)->sum('NUAS'));
            $kd['nilai_akhir_4'] = ($nilai_4) ? ($nilai_4 / 4) / $kd['count_ki4'] : 0;

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
            $i++;
        }
    } catch (\Exception $e) {
        $z = $kds->toArray();
        // dd($z);
        return dd($e);
    }
        $this->kds = $kds->toArray();
        $data['kds'] = $this->kds;
        $data['absensi'] = Absensi::where('student_class_id', $this->student_class->id)->where('semester', $semester)->first();
        $pdf = PDF::loadView('pdf.template', $data);
        // $pdf->download('invoice.pdf');
        // return view('pdf.template', $data);
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
    public function getKDAll($tingkat = null, $tahun = null, $semester, $student_class_id)
    {
        return KompetensiDasar::select('kompetensi_dasar.id as kompetensi_id', 'kompetensi_dasar.*', 'nilai.id as nilai_id', 'nilai.*', 'kompetensi_dasar.ki')
            ->when($tingkat, function ($query, $tingkat) {
                return $query->where('tingkat_kelas', $tingkat);
            })->where('tahun_ajaran_id', (!empty($tahun)) ? $tahun : 0)
            ->leftjoin('nilai', function ($join) use ($semester, $student_class_id) {
                $join->on('kompetensi_dasar.id', '=', 'nilai.kd_id')
                ->where('nilai.student_class_id', $student_class_id)
                    ->where('nilai.semester', $semester);
            })->with('course')->get()->where('course.is_active', 1);
    }
    public function downloadLegger($tahun_id, $class_id, $semester){
        $data = [];
        $rank = [];
        $data['semester'] = Semester::SEMESTER[$semester];
        $data['tahun'] = TahunAjaran::findOrFail($tahun_id);
        $data['class'] = Classes::findOrFail($class_id);
        $kds = TeacherCourse::where('tahun_ajaran_id', $tahun_id)->where('class_id', $class_id)->with('course')->with('classes')->get();
        $wali_kelas = WaliKelas::with('class')->with('user')->with('tahun_ajaran')->where('class_id',$class_id)->where('tahun_ajaran_id', $tahun_id)->first();
        $data['wali_kelas'] = $wali_kelas;
        $tingkat = Classes::findOrFail($class_id)->tingkat;
        foreach($kds as $kd){
            $kd['kkm'] = KKM::select('value')
            ->where('course_id', $kd->course->id)
            ->where('tingkat_kelas', $kd->classes->tingkat)
            ->where('tahun_ajaran_id', $tahun_id)
            ->first();
        }
        $students_class = StudentClass::where('tahun_ajaran_id', $tahun_id)->where('class_id', $class_id)->with('student')->get();
        //KI 1 & 2
        $nilaiKi = KompetensiInti::with('ki_detail')->get();



        foreach($students_class as $sc){

            foreach ($nilaiKi as $nilai) {
                $nilai->nilai_lengkap = true;
                $k = [];
                foreach ($nilai->ki_detail as $detail) {
                    $n = NilaiKI::select('value')->where('student_class_id', $sc->id)->where('ki_detail_id', $detail->id)->first();
                    $nilai->nilai_lengkap = (!$n || $n->value == 0) ? false : $nilai->nilai_lengkap;
                    $detail->value = ($n) ? $n->value : 0;
                    $k[] = $detail->kompetensi;
                }
                $nilai->avg = round($nilai->ki_detail->avg('value'));
                $nilai->predikat = ($nilai->avg == 4) ? "A" : (($nilai->avg == 3 ? "B" : (($nilai->avg == 2) ? "C" : "D")));
                $sc->nilai_KI[$nilai->kode] = $nilai;
            }
            //Nilai KI 3 & 4
            $sc['nilai'] = $this->getKDAll($tingkat, $tahun_id, $semester, $sc->id)->groupBy('course_id');
            $sc->jumlah_3 = 0;
            $sc->jumlah_4 = 0;
            try{
                foreach ($sc['nilai'] as $index => $kd) {
                    $kd['course'] = $kd[0]->course;
                    $kd['kkm'] = KKM::select('value')
                    ->where('course_id', $kd[0]->course->id)
                    ->where('tingkat_kelas', $tingkat)
                    ->where('tahun_ajaran_id', $tahun_id)
                    ->first();

                    $data['courses'][]= $kd[0]->course;
                    $nilai3 = (($kd->where('ki', 3)->sum('NH') * 2) + $kd->where('ki', 3)->sum('NUTS') + $kd->where('ki', 3)->sum('NUAS'));
                    $kd['nilai_akhir_3'] = ($nilai3) ? ($nilai3 / 4) / count($kd->where('ki', 3)) : 0;
                    $nilai4 = (($kd->where('ki', 4)->sum('NH') * 2) + $kd->where('ki', 4)->sum('NUTS') + $kd->where('ki', 4)->sum('NUAS'));
                    $kd['nilai_akhir_4'] = ($nilai4) ? ($nilai4 / 4) / count($kd->where('ki', 4)) : 0;
                    $sc->jumlah_3 += round($kd['nilai_akhir_3']);
                    $sc->jumlah_4 += round($kd['nilai_akhir_4']);
                }

                $sc->NR_3 = $sc->jumlah_3/count($students_class[0]['nilai']);
                $sc->NR_4 = $sc->jumlah_4/count($students_class[0]['nilai']);
                $sc->NRAll = ($sc->NR_3 + $sc->NR_4) / 2;
                array_push($rank, $sc->id."-".$sc->NRAll);
                $sc->absensi = Absensi::where('student_class_id', $sc->id)->where('semester', $semester)->first();
            } catch (\Exception $e) {
                // dd($z);
                return dd($e);
            }
        }
        for($i=0; $i<count($students_class);$i++){
            for($j=0; $j<count($students_class);$j++){
                if( $j<(count($students_class)-1) ){
                $nilai = explode("-", $rank[$j]);
                $nilai_next = explode("-", $rank[$j+1]);
                if($nilai[1]<$nilai_next[1]){
                    $temp = $rank[$j];
                    $rank[$j] = $rank[$j+1];
                    $rank[$j+1] = $temp;
                }
            }
            }
        }
        $ordered_rank = [];
        foreach($rank as $key => $r){
            $nilai = explode("-", $r);
            $ordered_rank[$nilai[0]] = $key+1;
        }
        // $nilaiKD = $this->getKDAll($tingkat, $tahun_id, $semester, $sc->id)->groupBy('course_id');
        $data['ordered_rank'] = $ordered_rank;
        $data['kds'] = $kds;
        $data['students_class'] = $students_class;
        $pdf = PDF::loadView('pdf.legger', $data)->setPaper('letter', 'landscape');;

        // return view('pdf.legger', $data);
        return $pdf->stream();
    }
}
