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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    //dashboard
    Route::get('/', App\Http\Livewire\Pages\Dashboard::class)->name('dashboard');
    //course
    Route::get('/courses/{kode?}/{class_id?}/{tahun_name?}', App\Http\Livewire\Pages\Course::class)->name('courses');


    Route::get('/users/edit/{id}', [App\Http\Livewire\UsersTable::class, "edit"])->name('users.edit');

    Route::get('/admin/users', App\Http\Livewire\Pages\Admin::class)->name('admin-users');
    Route::get('/admin/students', App\Http\Livewire\Pages\AdminStudents::class)->name('admin-students');
    Route::get('/admin/courses', App\Http\Livewire\Pages\AdminCourses::class)->name('admin-courses');
    Route::get('/admin/classes', App\Http\Livewire\Pages\AdminClasses::class)->name('admin-classes');
    Route::get('/admin/tahun_ajaran', App\Http\Livewire\Pages\AdminTahunAjaran::class)->name('admin-tahun-ajaran');
    Route::get('/admin/kelas_siswa', App\Http\Livewire\Pages\AdminStudentClass::class)->name('admin-kelas-siswa');
    Route::get('/admin/teacher_course', App\Http\Livewire\Pages\AdminTeacherCourse::class)->name('admin-teacher-course');
    Route::get('/admin/wali_kelas', App\Http\Livewire\Pages\AdminWaliKelas::class)->name('admin-wali-kelas');
    Route::get('/admin/kompetensi_dasar', App\Http\Livewire\Pages\AdminKompetensiDasar::class)->name('admin-kompetensi-dasar');
    Route::get('/admin', App\Http\Livewire\Pages\AdminGeneral::class)->name('admin-setting');
});
