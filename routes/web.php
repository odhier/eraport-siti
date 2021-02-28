<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
// */

Route::get('/forget-password', function () {
    return view('auth/passwords/forget_password');
});

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::group(['middleware' => 'auth'], function () {

    Route::get('users/export/', ['uses' => 'App\Http\Livewire\Pages\Admin@export']);
    Route::get('courses/export/{kode?}_{class_id?}_{tahun_id?}_{semester?}', ['uses' => 'App\Http\Livewire\Pages\Course@export']);
    Route::get('courses/export/{kode?}_{class_id?}_{tahun_id?}_{semester?}/view', ['uses' => 'App\Http\Controllers\HomeController@view']);
    //dashboard
    Route::get('/', App\Http\Livewire\Pages\Dashboard::class)->name('dashboard');
    //course

    Route::post('/courses/import', ['uses' => 'App\Http\Livewire\CourseTable@uploadFileImport'])->name('importNilai');
    Route::get('/courses/{kode?}/{class_id?}/{tahun_name?}', App\Http\Livewire\Pages\Course::class)->name('courses');
    Route::get('/class/{tahun_id?}/{class_id?}', App\Http\Livewire\Pages\Classes::class)->name('class');
    Route::get('/class/{tahun_id?}/{class_id?}/{semester?}/{student_class_id?}', App\Http\Livewire\Pages\DetailNilai::class)->name('class-student');

    Route::get('/raport/cetak_pdf/{tahun_id}_{class_id}_{semester}_{student_class_id}', ['uses' => 'App\Http\Controllers\PDFController@download']);

    Route::get('/users/edit/{id}', [App\Http\Livewire\UsersTable::class, "edit"])->name('users.edit');

    Route::get('/admin/users', App\Http\Livewire\Pages\Admin::class)->name('admin-users');
    Route::get('/admin/students', App\Http\Livewire\Pages\AdminStudents::class)->name('admin-students');
    Route::get('/admin/courses', App\Http\Livewire\Pages\AdminCourses::class)->name('admin-courses');
    Route::get('/admin/classes', App\Http\Livewire\Pages\AdminClasses::class)->name('admin-classes');
    Route::get('/admin/tahun_ajaran', App\Http\Livewire\Pages\AdminTahunAjaran::class)->name('admin-tahun-ajaran');
    Route::get('/admin/kelas_siswa', App\Http\Livewire\Pages\AdminStudentClass::class)->name('admin-kelas-siswa');
    Route::get('/admin/teacher_course', App\Http\Livewire\Pages\AdminTeacherCourse::class)->name('admin-teacher-course');
    Route::get('/admin/wali_kelas', App\Http\Livewire\Pages\AdminWaliKelas::class)->name('admin-wali-kelas');
    Route::get('/admin/kompetensi_inti', App\Http\Livewire\Pages\AdminKompetensiInti::class)->name('admin-kompetensi-inti');
    Route::get('/admin/kompetensi_dasar', App\Http\Livewire\Pages\AdminKompetensiDasar::class)->name('admin-kompetensi-dasar');
    Route::get('/admin', App\Http\Livewire\Pages\AdminGeneral::class)->name('admin-setting');
});
