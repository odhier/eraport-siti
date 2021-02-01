<?php

namespace App\Http\Livewire\Pages;

use App\Models\Absensi;
use App\Models\GeneralSetting;
use App\Models\KompetensiInti;
use App\Models\KompetensiIntiDetail;
use App\Models\Message;
use App\Models\MessageKI;
use App\Models\NilaiKI;
use App\Models\Saran;
use App\Models\Semester;
use App\Models\StudentClass;
use App\Models\WaliKelas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Classes extends Component
{

    protected $listeners = ['editForm', 'editAbsensi'];
    public $menu = [
        "_page" => 'Class',
        "_menus" => [
            []
        ],
        "_pilihTahun" => true,
    ];

    public $inputMore;
    public $tahun_id = "";
    public $class_id = "";
    public $classes;
    public $class_detail = "";
    public $current_ki;
    public $student_class;
    public $selected_semester;
    public $selected_semester_name;
    public $kds = [];
    public $deskripsi;
    public $nilai_akhir = 0;
    public $kode_ki;
    public $saran = ['saran' => ''];
    public $absensi = ['sakit' => '', 'izin' => '', 'tanpa_keterangan' => ''];

    public $validation_errors = [];

    public $subMenu = "Nilai";
    protected $rules = [
        'kds.*.value' => 'required',
    ];
    protected $messages = [
        "kds.*.*.required" => "Nilai ini belum diisi",
    ];
    public $rulesAbsensi = [
        'sakit' => 'numeric',
        'izin' => 'numeric',
        'tanpa_keterangan' => 'numeric',
    ];

    private $messagesAbsensi = [
        "sakit.numeric" => "Hanya boleh angka",
        "izin.numeric" => "Hanya boleh angka",
        "tanpa_keterangan.numeric" => "Hanya boleh angka",
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($tahun_id = null, $class_id = null)
    {
        $this->class_detail = "";
        $this->getAllClass($tahun_id);
        $this->class_detail = ($class_id) ? $this->getClassDetail($class_id) : null;
        if (empty($this->classes)) {
            $this->menu['_msg'] = "Sepertinya belum ada mata pelajaran untuk anda tahun ini";
        } else {
            unset($this->menu['_msg']);
        }
        $this->menu['_menus'] = [];
        foreach ($this->classes as $class) {
            $this->menu['_menus'][0][] = [
                "_text" => ($tahun_id == "all") ? $class['class']['tingkat'] . " (" . ucfirst($class['class']['name']) . ")" . " - {$class['tahun_ajaran']['tahun_ajaran']}" : $class['class']['tingkat'] . " (" . ucfirst($class['class']['name']) . ")",
                "_link" => "/class/" . $this->tahun_id . "/" . $class['id'],
            ];
        }
    }
    private function getAllClass($tahun_id = null)
    {
        if ($tahun_id == null && $tahun_id != "all") {
            $t = GeneralSetting::where('setting_name', 'tahun_ajaran_aktif')->first();
            $this->tahun_id = ($t) ? $t->setting_value : "all";
        }

        if (Auth::user()->role_id <= 2) {
            $this->classes = WaliKelas::whereHas('class', function ($query) {
                return $query->where('is_active', 1);
            });
        } else {
            $this->classes = WaliKelas::whereHas('class', function ($query) {
                return $query->where('is_active', 1);
            })->whereHas('user', function ($query) {
                return $query->where('id', Auth::user()->id);
            });
        }
        if ($this->tahun_id != null && $this->tahun_id != "all") {
            $this->classes = $this->classes->where('tahun_ajaran_id', $this->tahun_id);
        }
        $this->classes = $this->classes->with('class')->with('tahun_ajaran')->get()->toArray();
    }
    public function getClassDetail($id)
    {
        $this->class_id = $id;
        return WaliKelas::with('class')->with('user')->with('tahun_ajaran')->find($id);
    }
    public function emptyForm()
    {
        $this->kds = [];
        $this->deskripsi = "";
        $this->nilai_akhir = 0;
        $this->validation_errors = [];
        $this->resetErrorBag();
    }
    public function editAbsensi($id, $semester)
    {
        $this->student_class = StudentClass::where('id', $id)->with('student')->with('classes')->with('tahun_ajaran')->first();
        $this->selected_semester = $semester;
        $this->selected_semester_name = Semester::SEMESTER[$semester];

        $saran = Saran::where('student_class_id', $id)->where('semester', $semester)->first();
        $this->saran = ($saran) ? $saran->toArray() : $this->saran;

        $absensi = Absensi::where('student_class_id', $id)->where('semester', $semester)->first();
        $this->absensi = ($absensi) ? $absensi->toArray() : $this->absensi;
    }
    public function editForm($ki, $id, $semester)
    {
        $this->kds = [];
        $this->resetErrorBag();
        $this->current_ki = $ki;
        $this->kode_ki = KompetensiInti::find($ki)->kode;
        $this->student_class = StudentClass::where('id', $id)->with('student')->with('classes')->with('tahun_ajaran')->first();
        $this->selected_semester = $semester;
        $this->selected_semester_name = Semester::SEMESTER[$semester];
        $kds = $this->getKD()->toArray();
        foreach ($kds as $index => $kd) {
            $this->kds[] = array_map(function ($v) {
                return (is_null($v)) ? "" : $v;
            }, $kd);
        }
        $deskripsi = $this->getDeskripsi($this->student_class->classes->tingkat, $this->student_class->tahun_ajaran->id);
        $this->deskripsi = ($deskripsi) ? $deskripsi->toArray() : [];
    }
    public function getKD()
    {
        return KompetensiIntiDetail::select(
            'kompetensi_inti_detail.id as kid',
            'kompetensi_inti_detail.*',
            'nilai_ki.id as nilai_id',
            'nilai_ki.student_class_id',
            'nilai_ki.semester',
            'nilai_ki.ki_detail_id',
            'nilai_ki.teacher_id',
            'nilai_ki.value',
            'nilai_ki.created_at',
            'nilai_ki.updated_at'
        )
            ->where('ki_id', $this->current_ki)
            ->leftjoin('nilai_ki', function ($join) {
                $join->on('kompetensi_inti_detail.id', '=', 'nilai_ki.ki_detail_id')
                    ->where('nilai_ki.student_class_id', $this->student_class->id)
                    ->where('nilai_ki.semester', $this->selected_semester);
            })->with('ki')->get();
    }
    public function saveAbsensi()
    {
        $validator_object = Validator::make($this->absensi, $this->rulesAbsensi, $this->messagesAbsensi);
        if ($validator_object->fails()) {
            return $this->validation_errors = $validator_object->errors()->toArray();
        } else {
            try {
                $query_absensi = [
                    'sakit' => $this->absensi['sakit'],
                    'izin' => $this->absensi['izin'],
                    'tanpa_keterangan' => $this->absensi['tanpa_keterangan'],
                    'student_class_id' => $this->student_class['id'],
                    'semester' => $this->selected_semester,
                ];
                if (isset($this->absensi['id'])) {
                    $query_absensi["updated_at"] = \Carbon\Carbon::now();
                    Absensi::where('id', $this->absensi['id'])
                        ->update($query_absensi);
                } else {
                    $query_absensi["created_at"] = \Carbon\Carbon::now();
                    Absensi::insert($query_absensi);
                }

                $query_saran = [
                    'saran' => $this->saran['saran'],
                    'student_class_id' => $this->student_class['id'],
                    'teacher_id' => Auth::user()->id,
                    'semester' => $this->selected_semester,
                ];
                if (isset($this->saran['id'])) {
                    $query_saran["updated_at"] = \Carbon\Carbon::now();
                    Saran::where('id', $this->saran['id'])
                        ->update($query_saran);
                } else {
                    $query_saran["created_at"] = \Carbon\Carbon::now();
                    Saran::insert($query_saran);
                }
                $this->dispatchBrowserEvent('closeModal');
                $this->emptyForm();
                $this->emitTo('class-table', 'successMessage', 'Berhasil menyimpan data');
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('closeModal');
                return $this->emitTo('class-table', 'errorMessage', 'Gagal menyimpan data');
            }
            return $this->validation_errors = [];
        }
    }
    public function save()
    {
        try {
            $query_deskripsi = [
                'student_class_id' => $this->student_class['id'],
                'teacher_id' => Auth::user()->id,
                'semester' => $this->selected_semester,
                'deskripsi' => $this->deskripsi['deskripsi'],
                'ki_id' => $this->current_ki,
            ];
            if (isset($this->deskripsi['id'])) {
                $query_deskripsi["updated_at"] = \Carbon\Carbon::now();
                MessageKI::where('id', $this->deskripsi['id'])
                    ->update($query_deskripsi);
            } else {
                $query_deskripsi["created_at"] = \Carbon\Carbon::now();
                MessageKI::insert($query_deskripsi);
            }
            if (!$this->inputMore) {
                $this->dispatchBrowserEvent('closeModal');
                $this->emptyForm();
            }
            $this->emitTo('class-table', 'successMessage', 'Berhasil menyimpan data');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('closeModal');
            return $this->emitTo('class-table', 'errorMessage', 'Gagal menyimpan data');
        }
        if (!$this->getErrorBag()->has('kds.*.*')) {
            foreach ($this->kds as $index => $kd) {
                try {
                    $query = [
                        'student_class_id' => $this->student_class['id'],
                        'semester' => $this->selected_semester,
                        'ki_detail_id' => $kd['kid'],
                        'teacher_id' => Auth::user()->id,
                        'value' => ($kd['value']),
                    ];
                    if ($kd['nilai_id']) {
                        $query["updated_at"] = \Carbon\Carbon::now();
                        NilaiKI::where('id', $kd['nilai_id'])
                            ->update($query);
                    } else {
                        $query["created_at"] = \Carbon\Carbon::now();
                        NilaiKI::insert($query);
                    }

                    if (!$this->inputMore) {
                        $this->dispatchBrowserEvent('closeModal');
                        $this->emptyForm();
                    }
                    $this->emitTo('class-table', 'successMessage', 'Berhasil menyimpan data');
                } catch (\Exception $e) {
                    $this->dispatchBrowserEvent('closeModal');
                    $this->emitTo('class-table', 'errorMessage', 'Gagal menyimpan data');
                }
            }
        }
        $this->validation_errors = [];
    }
    public function getDeskripsi($tingkat = null, $tahun = null)
    {
        return MessageKI::where('student_class_id', $this->student_class['id'])
            ->where('semester', $this->selected_semester)
            ->where('ki_id', $this->current_ki)->first();
    }
    public function render()
    {
        return view('livewire.pages.classes');
    }
}
