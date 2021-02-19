<?php
$bulan = array (
		'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>RAPORT</title>
    <style>
        @font-face {
            font-family: 'Stencil';
            src: url({{ storage_path('fonts/StencilStd.ttf') }}) format('truetype');
            font-weight: bold;
            font-style: normal;
        }
        .header-title {
            font-family: "Stencil";
            font-weight: bold;
            line-height: .3;
        }
        .header{
            border-bottom: 3px solid black;
        }
        .w-100{
            width: 100%;
        }
        .position-relative{
            position: relative;
        }
        .position-absolute{
            position: absolute;
        }
        .text-center{
            text-align: center;
        }
        .logo{
            top: 10px;
        }
        .hr{
            margin-top:2px;
            border-bottom:1px solid black;
        }
        .mt-1{
            display: block;
        }
        .table-data tr td {
            vertical-align: top;
        }
        table, tr, td{
            padding: 0;
        }
        .title{
            font-weight: bold;
        }
        table th, table .head{
            text-align: center;
            font-weight: bold;
        }
        .table-bordered thead td, .table-bordered thead th {
            border-bottom-width: 2px;
        }
        .table-bordered{
            border: 1px solid black;
            border-collapse: collapse;
        }
        .table-bordered thead th, .head>td {
            vertical-align: bottom;
            border-bottom: 2px solid #000;
            background-color: #ccc;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #000;
        }
        .table-bordered td{
            padding: .5rem .25rem;
        }
        .number-col{
            width: 20px;
            text-align: center;
        }
        .sec-col{
            width: 120px;
        }
        .nilai{
            width: 35px;
        }
        .predikat{
            width: 30px
        }
        .nilai, .predikat{
            text-align: center;
        }
        .valign-mid{
            vertical-align: middle;
        }
        .py-0 tr td{
            padding-top: 0px;
            padding-bottom: 0px;
        }
        .px-2 tr td{
            padding-left: 5px;
            padding-right: 5px;
        }
        .flex-column {
            flex-direction: column!important;
        }
        .d-flex {
            display: flex!important;
        }
        .ttd{
            width: fit-content;
            text-align: center;
        }
        .ttd ul{
            padding: 0;
        }
        .ttd ul li{
            list-style: none;
            text-align: center;
        }
        .paraf{
            height: 70px;
            border-bottom: 1px solid black;
            width: 130px;
            margin: 0 auto;
        }

        @media print {
            tr.avoid-page-break  { display: block; page-break-after: avoid; }
        }
        table.print-friendly thead tr td, table.print-friendly thead tr th {
        page-break-inside: avoid;
    }
    .nobreak {
  page-break-inside: avoid;
}
    </style>
</head>
<body>
    <div class="header w-100 position-relative">
        <img class="position-absolute logo" src="{{public_path('images/logo-sitikhtiar.png')}}" alt="Logo SIT Ikhtiar" style="width:80px" srcset="Logo SIT Ikhtiar">
        <div class="header-title text-center">
            <p style="color:green">SEKOLAH DASAR ISLAM TERPADU IKHTIAR</p>
            <p style="color:green">SDIT IKHTIAR</p>
            <p style="color: red">ISLAMIC FULL DAY SCHOOL</p>
            <p style="font-size: .6rem"><i>Jl. Sunu (Kompleks UNHAS Baraya), Telp. (0411) 3690844, email : SD-IT_ikhtiar@yahoo.co.id Makassar - Sulawesi Selatan</i></p>
        </div>
    </div>
    <div class="hr w-100" style="display: block;margin-bottom:10px">  </div>
    <div style="height: 10px;"></div>
    <h4 class="text-center" style="display:block;margin-top:0px">RAPOR PESERTA DIDIK DAN PROFIL PESERTA DIDIK</h4>
    <table style="width:100%;font-size:.9rem">
        <tr>
            <td style="width:65%;vertical-align:top;">
                <table class="table-data">
                    <tr>
                        <td>Nama Peserta Didik</td>
                        <td>:</td>
                        <td style="font-weight: bold">{{$student_class['student']['name']}}</td>
                    </tr>
                    <tr>
                        <td>NISN</td>
                        <td>:</td>
                        <td>{{$student_class['student']['nisn']}}</td>
                    </tr>
                    <tr>
                        <td>Nama Sekolah</td>
                        <td>:</td>
                        <td>SDIT IKHTIAR</td>
                    </tr>
                    <tr>
                        <td>Alamat Sekolah</td>
                        <td>:</td>
                        <td>Jl. Sunu Komp. Unhas Baraya, Kel. Lembo Kec. Tallo, Makassar</td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align: top;">
                <table>
                    <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td >{{$student_class['classes']['tingkat']}} ( {{$student_class['classes']['name']}} )</td>
                    </tr>
                    <tr>
                        <td>Semester</td>
                        <td>:</td>
                        <td>{{$semester_name}}</td>
                    </tr>
                    <tr>
                        <td>Tahun Pelajaran</td>
                        <td>:</td>
                        <td>{{$wali_kelas['tahun_ajaran']['tahun_ajaran']}}</td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <div class="title">A. SIKAP</div>
    <table class="table-bordered w-100">
        <thead>
            <tr>
                <th colspan="3">DESKRIPSI</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nilaiKi as $index => $nilai)
            <tr>
                <td class="number-col">{{$index+1}}</td>
                <td class="sec-col">{{$nilai->name}}</td>
                <td>{{$nilai->message}}</td>
            </tr>
            @endforeach

        </tbody>
    </table>
    <div class="title" style="margin-top:5px;">B. PENGETAHUAN DAN KETRAMPILAN</div>
    <p style="margin-top:5px;margin-bottom:5px;">KKM Satuan Pendidikan = 80</p>
    <table class="table-bordered w-100">
        <thead>
            <tr class="avoid-page-break">
                <th rowspan="2" colspan="2" style="vertical-align: middle;">Muatan Pelajaran</th>
                <th colspan="3">Pengetahuan</th>
                <th colspan="3">Ketrampilan</th>
            </tr>
            <tr>
                <th style="background-color: white;">Nilai</th>
                <th style="background-color: white;">Predi</th>
                <th style="background-color: white;">Deskripsi</th>
                <th style="background-color: white;">Nilai</th>
                <th style="background-color: white;">Predi</th>
                <th style="background-color: white;">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1; @endphp
            @foreach ($kds as $indexnilai => $kd)
            <tr>
                <td class="number-col">{{$i}}</td>
                <td class="sec-col">{{$kd['course']['name']}}</td>
                <td class="nilai">{{round($kd['nilai_akhir_3'])}}</td>
                <td class="predikat">{{$kd['predikat_3']}}</td>
                <td class="desc">{{$kd['message_3']}}</td>
                <td class="nilai">{{round($kd['nilai_akhir_4'])}}</td>
                <td class="predikat">{{$kd['predikat_4']}}</td>
                <td class="desc">{{$kd['message_4']}}</td>
            </tr>
            @php $i++; @endphp
            @endforeach

        </tbody>
    </table>
<div class="nobreak">
    <div class="title" style="margin-top:20px;">C. Ekstrakurikuler</div>
    <table class="table-bordered w-100">
        <tbody>
            <tr class="head">
                <td style="width:200px;">Kegiatan Ekstrakurikuler</td>
                <td class="nilai">Nilai</td>
                <td>Keterangan</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

</div>
    <div class="title" style="margin-top:20px;">D. Saran-saran</div>
    <table class="table-bordered w-100">
        <tr>
            <td>
                {{$student_class['saran']}}
            </td>
        </tr>
    </table>
    <div class="nobreak">
    <div class="title" style="margin-top:20px;">E. Perkembangan Fisik</div>
    <table class="table-bordered w-100 py-0 px-2 print-friendly">
        <thead>
            <tr>
                <th class="number-col" style="vertical-align: middle;" rowspan="2">No</th>
                <th rowspan="2" class="valign-mid" style="vertical-align: middle;">Aspek Yang Dinilai</th>
                <th colspan="2">Semester</th>
            </tr>
            <tr>
                <th>1</th>
                <th>2</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="number-col ">1</td>
                <td>Tinggi</td>
                <td class="text-center">cm</td>
                <td class="text-center">cm</td>
            </tr>
            <tr>
                <td class="number-col ">2</td>
                <td>Berat</td>
                <td class="text-center">kg</td>
                <td class="text-center">kg</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="nobreak">
    <div class="title" style="margin-top:20px;">F. Kondisi Kesehatan</div>
    <table class="table-bordered w-100 py-0 px-2">
        <thead>
            <tr>
                <th class="number-col valign-mid" style="vertical-align: middle;" >No</th>
                <th class="valign-mid" style="vertical-align: middle;width:240px;" >Aspek Fisik</th>
                <th >Keterangan</th>
            </tr>

        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Pendengaran</td>
                <td class="text-center"></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Penglihatan</td>
                <td class="text-center"></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Gigi</td>
                <td class="text-center"></td>
            </tr>
            <tr>
                <td>4</td>
                <td> </td>
                <td class="text-center"> </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="nobreak">
    <div class="title" style="margin-top:20px;">G. Catatan Prestasi</div>
    <table class="w-100 table-bordered py-0 px-2">
        <tbody>
            <tr class="head">
                <td rowspan="2" style="vertical-align: middle" class="number-col">No</td>
                <td colspan="2">Semester 1</td>
                <td colspan="2">Semester 2</td>
            </tr>
            <tr class="head">
                <td>Jenis Prestasi</td>
                <td>Prestasi</td>
                <td>Jenis Prestasi</td>
                <td>Prestasi</td>
            </tr>
            <tr>
                <td>1</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>2</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="nobreak">
    <div class="title" style="margin-top:20px;">H. Ketidakhadiran</div>
    <table class=" py-0 px-2 table-bordered">
        <thead>
            <tr>
                <th style="width: 190px;">
                    Ketidakhadiran</th>
                <th ></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Sakit</td>
                <td style="text-align: right;width:130px;">{{($absensi && $absensi->sakit)?$absensi->sakit:""}} Hari</td>
            </tr>
            <tr>
                <td>Izin</td>
                <td style="text-align: right;width:130px;">{{($absensi && $absensi->izin)?$absensi->izin:""}} Hari</td>
            </tr>
            <tr>
                <td>Tanpa Keterangan</td>
                <td style="text-align: right;width:130px;">{{($absensi && $absensi['tanpa_keterangan'])?$absensi['tanpa_keterangan']:""}} Hari</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="nobreak">
    <table class="w-100" style="margin-top:30px;">
        <tr>
            <td style="text-align: left">
                <div class="ttd d-flex flex-column" style="margin-right: auto;width:200px;">
                    <ul>
                    <li>Mengetahui:</li>
                    <li>Orang Tua / Wali,</li>
                    <li style="height: 65px"></li>
                    @if($student_class['student']['parent_name'])
                    <li style="text-decoration: underline;font-weight:700;">{{$student_class['student']['parent_name']}}</li>
                    @else
                    <li>________________</li>
                    @endif
                </ul>
                </div>
            </td>

            <td class="text-right">
                <div class="ttd d-flex flex-column" style="margin-left: auto;width:250px;">

                    <ul>
                    <li>Makassar, {{date('d')}} {{$bulan[date('n')-1]}} {{date('Y')}}</li>
                    <li>Wali Kelas {{$student_class['classes']['tingkat']}} ( {{$student_class['classes']['name']}} )</li>
                    @if($wali_kelas['user']['paraf_img'])
                    <li style="height: 65px;background: url('{{public_path('storage/'.$wali_kelas['user']['paraf_img'])}}'); width:100%;border-radius: 5px;
                    background-position: center;
                    background-repeat: no-repeat;
                    background-size: contain;"></li>
                    @else
                    <li style="height:65px"></li>
                    @endif
                    <li style="text-decoration: underline;font-weight:700;">{{$wali_kelas['user']['name']}}</li>
                    <li>NIP. {{($wali_kelas['user']['NIP'])?$wali_kelas['user']['NIP']:"-"}}</li>
                </ul>
                </div>
            </td>
        </tr>
        <tr>
            <td class="text-center" style="width: 100%;">
                <div class="ttd d-flex flex-column" style="margin-left: auto;width:250px;">
                <ul>
                    <li>Kepala Sekolah,</li>
                    <li style="height: 65px;background: url('{{public_path('images/paraf_kepsek.png')}}'); width:100%;border-radius: 5px;
                    background-position: center;
                    background-repeat: no-repeat;
                    background-size: contain;"></li>
                    <li style="text-decoration: underline;font-weight:700;">Masita Dasa. S.Sos.. M.Pd.I</li>
                    <li>NIP. {{($wali_kelas['user']['NIP'])?$wali_kelas['user']['NIP']:"-"}}</li>
                </ul>
                <div style="background: url('{{public_path('images/cap_sitikhtiar.png')}}'); background-position: left bottom;
                background-repeat: no-repeat;
                background-size: contain;width:100%;height:90px;position:relative; left:-30px;top:30px"></div>
                </div>
            </td>
        </tr>
    </table>

</div>
</body>
</html>
