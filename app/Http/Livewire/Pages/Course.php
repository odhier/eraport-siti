<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use App\Models\TeacherCourse;
use App\Models\Classes;
use App\Models\GeneralSetting;
use App\Models\KKM;
use App\Models\KompetensiDasar;
use App\Models\LastCourse;
use App\Models\Message;
use App\Models\Nilai;
use App\Models\Semester;
use App\Models\StudentClass;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Auth;


class Course extends Component
{
    protected $listeners = ['changeTahun', 'rerenderSidebar' => '$refresh', 'editForm'];
    public $menu = [
        "_page" => 'Course',
        "_menus" => [
            []
        ],
        "_pilihTahun" => true,
    ];
    public $subMenu = "Nilai";
    public $current_ki = 0;
    public $course_code;
    public $course;
    public $courses;
    public $tahun;
    public $tahun_name;
    public $class_id;
    public $class;
    public $class_name;
    public $selected_semester;
    public $student_class;
    public $kds = [];
    public $nuas;
    public $inputMore;
    public $selected_semester_name;
    public $nilai_akhir = 0;
    public $validation_errors = [];
    public $kkm = 0;
    public $deskripsi;

    protected $rules = [
        'kds.*.NH' => 'numeric|min:0|max:100',
        'kds.*.NUTS' => 'numeric|min:0|max:100',
        'kds.*.NUAS' => 'numeric|min:0|max:100',
        'deskripsi.deskripsi' => '',
    ];
    protected $messages = [
        "kds.*.*.numeric" => "Nilai hanya berupa angka",
        "kds.*.*.min" => "Nilai min = 0",
        "kds.*.*.max" => "Nilai max = 100",
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function mount($kode = null)
    {

        $this->course_code = $kode;
        $this->getAllCourses();
        if (empty($this->courses)) {
            $this->menu['_msg'] = "Sepertinya belum ada mata pelajaran untuk anda tahun ini";
        }
        foreach ($this->courses as $course) {
            $this->menu['_menus'][0][] = [
                "_text" => ucfirst($course[0]['course']['name']),
                "_link" => "/courses/" . $course[0]['course']['kode'],
            ];
        }
        $this->class = ($this->class_id) ? Classes::where('id', $this->class_id)->first() : null;
        $this->class_name = ($this->class) ? "Kelas " . $this->class->tingkat . " (" . $this->class->name . ")" : "";

        $this->tahun = ($this->tahun_name) ? $this->getTahunId() : null;
        $this->getCourse();
        $setting_semester = GeneralSetting::select('setting_value')->where('setting_name', 'semester_aktif')->first();
        $this->selected_semester = ($setting_semester) ? $setting_semester->setting_value : 1;
        if ($this->course) {
            LastCourse::insert([
                'teacher_course_id' => $this->course->id,
                'teacher_id' => Auth::user()->id,
                'created_at' => \Carbon\Carbon::now(),
            ]);
        }
    }

    private function getCourse()
    {
        $this->course = TeacherCourse::whereHas('course', function ($query) {
            return $query->where('kode', $this->course_code);
        })->with('course')->first();
    }
    private function getAllCourses($tahun = null)
    {
        if ($tahun == null) {
            $t = GeneralSetting::where('setting_name', 'tahun_ajaran_aktif')->first();
            $tahun = ($t) ? $t->setting_value : "all";
            $this->tahun = $t->setting_value;
        }

        if (Auth::user()->role_id <= 2) {
            $this->courses = TeacherCourse::whereHas('course', function ($query) {
                return $query->where('is_active', 1);
            });
        } else {
            $this->courses = TeacherCourse::whereHas('course', function ($query) {
                return $query->where('is_active', 1);
            })->whereHas('user', function ($query) {
                return $query->where('id', Auth::user()->id);
            });
        }
        if ($tahun != null && $tahun != "all") {
            $this->courses = $this->courses->where('tahun_ajaran_id', $tahun);
        }
        $this->courses = $this->courses->with('course')->get()->groupBy('course_id')->toArray();
    }
    public function getTahunId()
    {
        return TahunAjaran::where('tahun_ajaran', str_replace('-', '/', $this->tahun_name))->first();
    }
    public function changeTahun($tahun)
    {
        $this->getAllCourses($tahun);
        if (empty($this->courses)) {
            $this->menu['_msg'] = "Sepertinya belum ada mata pelajaran untuk anda tahun ini";
        } else {
            unset($this->menu['_msg']);
        }
        $this->menu['_menus'] = [];
        foreach ($this->courses as $course) {
            $this->menu['_menus'][0][] = [
                "_text" => ucfirst($course[0]['course']['name']),
                "_link" => "/courses/" . $course[0]['course']['kode'] . "/0/" . str_replace('/', '-', $this->tahun_name),
            ];
        }
        $this->emitTo('partials.menu', 'getNewMenu', $this->menu);
    }
    public function editForm($ki, $id, $semester)
    {
        $this->kds = [];
        $this->resetErrorBag();
        $this->current_ki = $ki;
        $this->student_class = StudentClass::where('id', $id)->with('student')->with('classes')->with('tahun_ajaran')->first();
        $this->selected_semester = $semester;
        $this->selected_semester_name = Semester::SEMESTER[$semester];
        $kds = $this->getKD($this->student_class->classes->tingkat, $this->student_class->tahun_ajaran->id)->toArray();
        foreach ($kds as $index => $kd) {
            $this->kds[] = array_map(function ($v) {
                return (is_null($v)) ? "" : $v;
            }, $kd);
        }
        $kkm = $this->getKKM($this->student_class->classes->tingkat, $this->student_class->tahun_ajaran->id);
        $this->kkm = ($kkm) ? $kkm->value : 0;

        $deskripsi = $this->getDeskripsi($this->student_class->classes->tingkat, $this->student_class->tahun_ajaran->id);
        $this->deskripsi = ($deskripsi) ? $deskripsi->toArray() : [];
    }
    public function getKD($tingkat = null, $tahun = null)
    {
        return KompetensiDasar::select('kompetensi_dasar.id as kompetensi_id', 'kompetensi_dasar.*', 'nilai.id as nilai_id', 'nilai.*')
            ->where('course_id', $this->course->course->id)
            ->when($tingkat, function ($query, $tingkat) {
                return $query->where('tingkat_kelas', $tingkat);
            })->where('tahun_ajaran_id', (!empty($tahun)) ? $tahun : 0)
            ->where('ki', $this->current_ki)
            ->leftjoin('nilai', function ($join) {
                $join->on('kompetensi_dasar.id', '=', 'nilai.kd_id')
                    ->where('nilai.student_class_id', $this->student_class->id)
                    ->where('nilai.semester', $this->selected_semester);
            })->get();
    }
    public function getKKM($tingkat = null, $tahun = null)
    {
        return KKM::where('course_id', $this->course->course->id)->when($tingkat, function ($query, $tingkat) {
            return $query->where('tingkat_kelas', $tingkat);
        })->where('tahun_ajaran_id', (!empty($tahun)) ? $tahun : 0)
            ->where('ki', $this->current_ki)->first();
    }
    public function getDeskripsi($tingkat = null, $tahun = null)
    {

        return Message::where('teacher_course_id', $this->course->id)
            ->where('student_class_id', $this->student_class['id'])
            ->where('semester', $this->selected_semester)
            ->where('ki', $this->current_ki)->first();
    }
    public function emptyForm()
    {
        $this->kds = [];
        $this->deskripsi = "";
        $this->resetErrorBag();
    }
    public function save()
    {
        try {
            $this->deskripsi['deskripsi'] = (isset($this->deskripsi['deskripsi'])) ? $this->deskripsi['deskripsi'] : "";
            $query_deskripsi = [
                'student_class_id' => $this->student_class['id'],
                'teacher_course_id' => $this->course->id,
                'semester' => $this->selected_semester,
                'deskripsi' => $this->deskripsi['deskripsi'],
                'ki' => $this->current_ki,
            ];
            if (isset($this->deskripsi['id'])) {
                $query_deskripsi["updated_at"] = \Carbon\Carbon::now();
                Message::where('id', $this->deskripsi['id'])
                    ->update($query_deskripsi);
            } else {

                $query_deskripsi["created_at"] = \Carbon\Carbon::now();
                Message::insert($query_deskripsi);
            }
        } catch (\Exception $e) {

            $this->dispatchBrowserEvent('closeModal');
            return $this->emitTo('course-table', 'errorMessage', 'Gagal menyimpan data');
        }


        if (!$this->getErrorBag()->has('kds.*.*')) {
            foreach ($this->kds as $index => $kd) {
                try {
                    $query = [
                        'student_class_id' => $this->student_class['id'],
                        'semester' => $this->selected_semester,
                        'kd_id' => $kd['kompetensi_id'],
                        'teacher_id' => Auth::user()->id,
                        'NH' => ($kd['NH'] == "") ? null : floatval($kd['NH']),
                        'NUTS' => ($kd['NUTS'] == "") ? null : floatval($kd['NUTS']),
                        'NUAS' => ($kd['NUAS'] == "") ? null : floatval($kd['NUAS']),
                    ];
                    if ($kd['nilai_id']) {
                        $query["updated_at"] = \Carbon\Carbon::now();
                        Nilai::where('id', $kd['nilai_id'])
                            ->update($query);
                    } else {
                        $query["created_at"] = \Carbon\Carbon::now();
                        Nilai::insert($query);
                    }


                    if (!$this->inputMore) {
                        $this->dispatchBrowserEvent('closeModal');
                        $this->emptyForm();
                    }
                    $this->emitTo('course-table', 'successMessage', 'Berhasil menyimpan data');
                } catch (\Exception $e) {
                    $this->dispatchBrowserEvent('closeModal');
                    $this->emitTo('course-table', 'errorMessage', 'Gagal menyimpan data');
                }
            }
        }
        $this->validation_errors = [];
    }
    public function getTahunName($tahun_id)
    {
        return TahunAjaran::find($tahun_id)->tahun_ajaran;
    }

    public function render()
    {
        return view('livewire.pages.course');
    }
}
