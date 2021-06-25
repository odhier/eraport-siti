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
$total_students = count($students_class);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Legger</title>
    <style>
        @font-face {
            font-family: 'Roboto';
            src: url({{ storage_path('fonts/Roboto-bold.ttf') }}) format('truetype');
            font-weight: bold;
            font-style: normal;
        }
        .header-title {
            font-family: "Roboto";
            font-weight: bold;
            line-height: .3;
        }
        .header{
            /* border-bottom: 3px solid black; */
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
            <p style="">DAFTAR LEGGER NILAI RAPOR</p>
            <p style="">SEKOLAH DASAR ISLAM TERPADU IKHTIAR</p>
            <p style="">{{strtoupper($class->name)}} SEMESTER {{strtoupper($semester)}}</p>
            <p style="">TAHUN PELAJARAN {{str_replace("/","-",$tahun->tahun_ajaran)}}</p>
        </div>
    </div>
    <div style="height: 10px;"></div>
    <table class="table-bordered w-100" style="font-size: .6rem">
        <thead>
            <tr  style="height: 0;">
                <th rowspan="2" style="vertical-align: middle;width: 20px"">NO</th>
                <th rowspan="2" style="vertical-align: middle;width: 250px">NAMA SISWA</th>
                <th style="width:80px">ASPEK</th>
                @foreach($students_class[0]['nilai'] as $course)

                <th style="width:30px">{{$course['course']->kode}}</th>
                @endforeach
                <th style="height:30px;vertical-align: middle;width:30px" rowspan="2"><div style="writing-mode: vertical-rl;
                    -webkit-transform:rotate(270deg);
                    -moz-transform:rotate(270deg);
                    -o-transform: rotate(270deg);
                    -ms-transform:rotate(270deg);
                    transform: rotate(270deg);">Spiritual</div> </th>
                <th style="height:30px;vertical-align: middle;width:30px" rowspan="2"><div style="writing-mode: vertical-rl;
                    -webkit-transform:rotate(270deg);
                    -moz-transform:rotate(270deg);
                    -o-transform: rotate(270deg);
                    -ms-transform:rotate(270deg);
                    transform: rotate(270deg);">Sosial</div> </th>
                <th rowspan="2" style="width:30px;vertical-align: middle">Jml</th>
                <th rowspan="2" style="width:30px;vertical-align: middle">NR</th>
                <th rowspan="2" style="width:30px;vertical-align: middle">NR P&K</th>
                <th colspan="3" style="text-align: center">Absensi</th>
                <th style="height:30px;vertical-align: middle;" rowspan="2"><div style="writing-mode: vertical-rl;
                    -webkit-transform:rotate(270deg);
                    -moz-transform:rotate(270deg);
                    -o-transform: rotate(270deg);
                    -ms-transform:rotate(270deg);
                    transform: rotate(270deg);">Rank</div></th>
            </tr>
            <tr>
                <th>KKM</th>
                @foreach($students_class[0]['nilai'] as $nilai)
                <th>@if($nilai['kkm']) {{$nilai['kkm']->value}} @else {{"-"}} @endif </th>
                @endforeach
                <th style="width:30px;">S</th>
                <th style="width:30px;">I</th>
                <th style="width:30px;">A</th>
            </tr>
        </thead>
        <tbody>
            @php
            $i = 1;
            $sum['total_3'] = [];
            $sum['total_4'] = [];
            $sum['NR_3'] = 0; $sum['NR_4'] = 0;
            $sum['NRAll'] = 0;
            $sum['sakit'] = 0;
            $sum['izin'] = 0;
            $sum['alpha'] = 0;
            $sum['terendah_3'] = [];
            $sum['terendah_4'] = [];
            $sum['tertinggi_3'] = [];
            $sum['tertinggi_4'] = [];
            @endphp
            @foreach ($students_class as $student_class)

            <tr>
                <td rowspan="3" style="text-align: center;height: 0px;padding:0;">{{$i}}</td>
                <td rowspan="3" style="height: 0px;padding:0; padding-left: 2px;">{{$student_class->student->name}}</td>
                <td style="height: 0px; padding: 0px;padding-left:2px">Pengetahuan</td>
                @foreach ($student_class->nilai as $index => $nilai)
                    @php
                        if(!isset($sum['terendah_3'][$index])) $sum['terendah_3'][$index] = 100;
                        if(!isset($sum['terendah_4'][$index])) $sum['terendah_4'][$index] = 100;
                        if(!isset($sum['tertinggi_3'][$index])) $sum['tertinggi_3'][$index] = 0;
                        if(!isset($sum['tertinggi_4'][$index])) $sum['tertinggi_4'][$index] = 0;

                        $sum['total_3'][$index] = (isset($sum['total_3'][$index])) ? $sum['total_3'][$index]+round($nilai['nilai_akhir_3']):round($nilai['nilai_akhir_3']);
                        $sum['total_4'][$index] = (isset($sum['total_4'][$index])) ? $sum['total_4'][$index]+round($nilai['nilai_akhir_4']):round($nilai['nilai_akhir_4']);

                        $sum['terendah_3'][$index] = ($sum['terendah_3'][$index]>$nilai['nilai_akhir_3']) ? $nilai['nilai_akhir_3']:$sum['terendah_3'][$index];
                        $sum['terendah_4'][$index] = ($sum['terendah_4'][$index]>$nilai['nilai_akhir_4']) ? $nilai['nilai_akhir_4']:$sum['terendah_4'][$index];

                        $sum['tertinggi_3'][$index] = ($sum['tertinggi_3'][$index]<$nilai['nilai_akhir_3']) ? $nilai['nilai_akhir_3']:$sum['tertinggi_3'][$index];
                        $sum['tertinggi_4'][$index] = ($sum['tertinggi_4'][$index]<$nilai['nilai_akhir_4']) ? $nilai['nilai_akhir_4']:$sum['tertinggi_4'][$index];

                    @endphp
                    <td style="height: 0px; padding: 0px;text-align: center;">{{round($nilai['nilai_akhir_3'])}}</td>
                @endforeach
                <td rowspan="2" style="background: #ccc;height: 0px;padding:0;"></td>
                <td rowspan="2" style="background: #ccc;height: 0px;padding:0;"></td>
                <td style="text-align: center;height: 0px;padding:0;">{{$student_class->jumlah_3}}</td>
                <td style="text-align: center;height: 0px;padding:0;">{{round($student_class->NR_3,2)}}</td>
                <td style="vertical-align:middle;text-align: center;height: 0px;padding:0;" rowspan="2">{{round($student_class->NRAll, 2)}}</td>
                <td rowspan="3" style="vertical-align: middle;text-align: center;height: 0px;padding:0">{{($student_class->absensi && $student_class->absensi->sakit)?$student_class->absensi->sakit:"0"}}</td>
                <td rowspan="3" style="vertical-align: middle;text-align: center;height: 0px;padding:0">{{($student_class->absensi && $student_class->absensi->izin)?$student_class->absensi->izin:"0"}}</td>
                <td rowspan="3" style="vertical-align: middle;text-align: center;height: 0px;padding:0">{{($student_class->absensi && $student_class->absensi->alpha)?$student_class->absensi->alpha:"0"}}</td>
                <td rowspan="3" style="vertical-align: middle;text-align: center;height: 0px;padding:0">{{$ordered_rank[$student_class->id]}}</td>
            </tr>
            <tr>
                <td style="height: 0px; padding: 0px;padding-left:2px">Ketrampilan</td>
                @foreach ($student_class->nilai as $index => $nilai)
                    <td style="height: 0px; padding: 0px;text-align: center;">{{round($nilai['nilai_akhir_4'])}}</td>
                @endforeach
                <td style="text-align: center;height: 0px;padding:0;">{{$student_class->jumlah_4}}</td>
                <td style="text-align: center;height: 0px;padding:0;">{{round($student_class->NR_4, 2)}}</td>
            </tr>
            <tr>
                <td style="height: 0px; padding: 0px;padding-left:2px">Sikap</td>
                <td colspan="{{ count($students_class[0]['nilai'])}}" style="height: 0px;padding:0;background: #ccc"></td>
                <td style="height: 0px;padding:0;text-align: center">{{$student_class->nilai_KI[1]->predikat}}</td>
                <td style="height: 0px;padding:0;text-align: center">{{$student_class->nilai_KI[1]->predikat}}</td>
                <td colspan="3" style="height: 0px;padding:0;background:#ccc;border:1px solid #000"></td>
            </tr>

            @php
            $i++;
            $sum['NR_3'] += round($student_class->NR_3, 2);
            $sum['NR_4'] += round($student_class->NR_4, 2);
            $sum['NRAll'] += round($student_class->NRAll, 2);
            $sum['sakit'] = ($student_class->absensi && $student_class->absensi->sakit)?$student_class->absensi->sakit+$sum['sakit']:$sum['sakit']+0;
            $sum['izin'] = ($student_class->absensi && $student_class->absensi->izin)?$student_class->absensi->izin+$sum['izin']:$sum['izin']+0;
            $sum['alpha'] = ($student_class->absensi && $student_class->absensi->alpha)?$student_class->absensi->alpha+$sum['alpha']:$sum['alpha']+0;
            @endphp
            @endforeach
            <tr>
                <td colspan="2" rowspan="2" style="font-style:italic;text-align:center;padding: 0;height: 0;background:#eee"><b>Jumlah Nilai</b></td>
                <td style="height: 0px;padding:0;background:#eee">Pengetahuan</td>
                @foreach ($student_class->nilai as $index => $nilai)
                    <td style="height: 0px; padding: 0px;text-align: center;background:#eee">{{$sum['total_3'][$index]}}</td>
                @endforeach
                <td rowspan="9" style="padding: 0;height: 0;;background:#eee"></td>
                <td rowspan="9" style="padding: 0;height: 0;;background:#eee"></td>
                <td style="padding: 0;height: 0;text-align:center;background:#eee">{{array_sum($sum['total_3'])}}</td>
                <td style="padding: 0;height: 0;text-align:center;background:#eee">{{round($sum['NR_3'])}}</td>
                <td style="padding: 0;height: 0;text-align:center;background:#eee" rowspan="2">{{round($sum['NRAll'])}}</td>
                <td rowspan="9" style="padding: 0;height: 0;text-align:center;background:#eee">{{$sum['sakit']}}</td>
                <td rowspan="9" style="padding: 0;height: 0;text-align:center;background:#eee">{{$sum['izin']}}</td>
                <td rowspan="9" style="padding: 0;height: 0;text-align:center;background:#eee">{{$sum['alpha']}}</td>
                <td rowspan="9" style="padding: 0;height: 0;text-align:center;background:#eee"></td>
            </tr>
            <tr>
                <td style="height: 0px;padding:0;background:#eee">Keterampilan</td>
                @foreach ($student_class->nilai as $index => $nilai)
                    <td style="height: 0px; padding: 0px;text-align: center;background:#eee">{{$sum['total_4'][$index]}}</td>
                @endforeach
                <td style="padding: 0;height: 0;text-align:center;background:#eee">{{array_sum($sum['total_4'])}}</td>
                <td style="padding: 0;height: 0;text-align:center;background:#eee">{{round($sum['NR_4'])}}</td>
            </tr>
            <tr>
                <td colspan="2" style="background:#eee"></td>
                <td style="background:#eee"></td>

                @foreach($students_class[0]['nilai'] as $course)

                <th style="width:30px;background:#ccc;">{{$course['course']->kode}}</th>
                @endforeach
                <td style="padding: 0;height: 0;text-align:center;background:#eee"></td>
                <td style="padding: 0;height: 0;text-align:center;background:#eee"></td>
                <td style="padding: 0;height: 0;text-align:center;background:#eee"></td>

            </tr>
            <tr>
                <td rowspan="2" colspan="2" style="font-style:italic;text-align:center;padding: 0;height: 0;background:#eee"><b>Nilai Rata-rata<b></td>
                <td style="height: 0px;padding:0;background:#eee">Pengetahuan</td>
                @foreach ($student_class->nilai as $index => $nilai)
                    <td style="height: 0px; padding: 0px;text-align: center;background:#eee">{{round($sum['total_3'][$index]/$total_students)}}</td>
                @endforeach

                <td style="padding: 0;height: 0;text-align:center;background:#eee">{{round(array_sum($sum['total_3'])/$total_students)}}</td>
                <td style="padding: 0;height: 0;text-align:center;background:#eee">{{round(round($sum['NR_3'])/$total_students)}}</td>
                <td style="padding: 0;height: 0;text-align:center;background:#eee" rowspan="2">{{round(round($sum['NRAll'])/$total_students)}}</td>
            </tr>
            <tr>
                <td style="height: 0px;padding:0;background:#eee">Keterampilan</td>
                @foreach ($student_class->nilai as $index => $nilai)
                    <td style="height: 0px; padding: 0px;text-align: center;background:#eee">{{round($sum['total_4'][$index]/$total_students)}}</td>
                @endforeach

                <td style="padding: 0;height: 0;text-align:center;background:#eee">{{round(array_sum($sum['total_4'])/$total_students)}}</td>
                <td style="padding: 0;height: 0;text-align:center;background:#eee">{{round(round($sum['NR_4'])/$total_students)}}</td>
            </tr>
            <tr>
                <td rowspan="2" colspan="2" style="background:#eee">Nilai Terendah</td>
                <td style="height: 0px;padding:0;background:#eee">Pengetahuan</td>
                @foreach ($student_class->nilai as $index => $nilai)
                    <td style="height: 0px; padding: 0px;text-align: center;background:#eee">{{round($sum['terendah_3'][$index])}}</td>
                @endforeach
                <td style="padding: 0;height: 0;text-align:center;background:#eee">{{$students_class->min('jumlah_3')}}</td>
                <td style="padding: 0;height: 0;text-align:center;background:#eee">{{round($students_class->min('NR_3'))}}</td>
                <td style="padding: 0;height: 0;text-align:center;background:#eee" rowspan="2">{{round($students_class->min('NRAll'))}}</td>
            </tr>
            <tr>
                <td style="height: 0px;padding:0;background:#eee">Keterampilan</td>
                @foreach ($student_class->nilai as $index => $nilai)
                    <td style="height: 0px; padding: 0px;text-align: center;background:#eee">{{round($sum['terendah_4'][$index])}}</td>
                @endforeach
                <td style="padding: 0;height: 0;text-align:center;background:#eee">{{$students_class->min('jumlah_4')}}</td>
                <td style="padding: 0;height: 0;text-align:center;background:#eee">{{round($students_class->min('NR_4'))}}</td>
            </tr>
            <tr>
                <td rowspan="2" colspan="2" style="background:#eee">Nilai Tertinggi</td>
                <td style="height: 0px;padding:0;background:#eee">Pengetahuan</td>
                @foreach ($student_class->nilai as $index => $nilai)
                    <td style="height: 0px; padding: 0px;text-align: center;background:#eee">{{round($sum['tertinggi_3'][$index])}}</td>
                @endforeach
                <td style="padding: 0;height: 0;text-align:center;background:#eee">{{$students_class->max('jumlah_3')}}</td>
                <td style="padding: 0;height: 0;text-align:center;background:#eee">{{round($students_class->max('NR_3'))}}</td>
                <td style="padding: 0;height: 0;text-align:center;background:#eee" rowspan="2">{{round($students_class->max('NRAll'))}}</td>
            </tr>
            <tr>
                <td style="height: 0px;padding:0;background:#eee">Keterampilan</td>
                @foreach ($student_class->nilai as $index => $nilai)
                    <td style="height: 0px; padding: 0px;text-align: center;background:#eee">{{round($sum['tertinggi_4'][$index])}}</td>
                @endforeach
                <td style="padding: 0;height: 0;text-align:center;background:#eee">{{$students_class->max('jumlah_4')}}</td>
                <td style="padding: 0;height: 0;text-align:center;background:#eee">{{round($students_class->max('NR_4'))}}</td>
            </tr>
        </tbody>
    </table>
    <div class="nobreak">
    <table class="w-100" style="margin-top:30px;">
        <tr>
            <td style="text-align: left;position: relative;">
                <div class="ttd d-flex flex-column" style="margin-right: auto;width:200px;">
                    <ul>
                    <li>Kepala Sekolah,</li>
                    <li style="height: 95px;background: url('{{public_path('images/paraf_kepsek.png')}}'); width:100%;border-radius: 5px;
                    background-position: center;
                    background-repeat: no-repeat;
                    background-size: contain;"></li>
                    @if($student_class['student']['parent_name'])
                    <li style="text-decoration: underline;font-weight:700;">Masita Dasa. S.Sos.. M.Pd.I</li>
                    <li>NIP. {{($wali_kelas['user']['NIP'])?$wali_kelas['user']['NIP']:"-"}}</li>
                    @else
                    <li>________________</li>
                    @endif
                </ul>
                <div style="background: url('{{public_path('images/cap_sitikhtiar.png')}}'); background-position: left bottom;
                background-repeat: no-repeat;
                background-size: contain;width:250px;height:90px;position:absolute;top:60px;left:-30px"></div>
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

    </table>

</div>
</body>
</html>
