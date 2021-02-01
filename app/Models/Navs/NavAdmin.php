<?php

namespace App\Models\Navs;

class NavAdmin
{
    static private $menu = [
        "_page" => 'Admin',
        "_menus" => [
            [
                ["_text" => "General", "_route" => 'admin-setting'],
            ],
            [
                ["_text" => "Users/Teachers", "_route" => 'admin-users'],
                ["_text" => "Students", "_route" => 'admin-students'],
                ["_text" => "Courses", "_route" => 'admin-courses'],
                ["_text" => "Classes", "_route" => 'admin-classes'],
                ["_text" => "Tahun Ajaran", "_route" => 'admin-tahun-ajaran'],
            ],
            [
                ["_text" => "Kelas Siswa", "_route" => 'admin-kelas-siswa'],
                ["_text" => "Guru Mata Pelajaran", "_route" => 'admin-teacher-course'],
                ["_text" => "Wali Kelas", "_route" => 'admin-wali-kelas'],
                ["_text" => "Kompetensi Inti", "_route" => 'admin-kompetensi-inti'],
                ["_text" => "Kompetensi Dasar & KKM", "_route" => 'admin-kompetensi-dasar'],
            ],
        ],
    ];
    public static function getMenu()
    {

        return self::$menu;
    }
}
