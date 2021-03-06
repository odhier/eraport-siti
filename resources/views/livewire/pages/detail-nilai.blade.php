<div class="container">
    @push('pagetitle', 'Detail Nilai')
    <div class="row w-100">

        <div class="col-12 main-content position-relative ml-5 bg-white pr-5">
            <a class="hover:no-underline" href="/class/{{$tahun_id}}/{{$wali_kelas->id}}"><i class="fas fa-arrow-left"></i> Back</a>
            <h2>{{$student_class->student->name}}  </h2>
            <div class="row">
                <div class="col">
                    <span class="antialiased text-base text-gray-600">{{$wali_kelas->class->tingkat}} {{$wali_kelas->class->name}} - {{$wali_kelas->tahun_ajaran->tahun_ajaran}} (Semester {{$semester_name}})</span>
                </div>
                <div class="col text-right">
                    <a target="_blank" href='/raport/cetak_pdf/{{$tahun_id}}_{{$wali_kelas->id}}_{{$semester}}_{{$student_class->id}}' class='border-orange-500 border-opacity-75 border-2 rounded-xl p-1 shadow-sm text-orange-500 hover:text-orange-500 hover:no-underline cursor-pointer'>Print Nilai <i class='fas fa-print'></i></a>

                </div>
            </div>
            <div class="mb-3"></div>
            <div class="title">A. Sikap</div>
            <table class="table table-condensed table-striped table-bordered" style="border-collapse:collapse;">
                <thead class="thead-light">

                    <tr>

                        <th class=" text-center">#</th>
                        <th class=" text-center">Kompetensi</th>
                        <th class=" text-center">Predikat</th>

                        <th class=" text-center">Deskripsi</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($nilaiKi as $index => $nilai)
                    <tr >
                        <td>{{$index+1}}</td>
                        <td>{{$nilai->name}}</td>
                        <td class="text-green-700">
                            @switch($nilai->nilai_akhir)
                                @case(1)
                                    PB
                                @break
                                @case(2)
                                    MM
                                @break
                                @case(3)
                                    B
                                @break
                                @case(4)
                                    SB
                                @break
                                @default
                                    <span>-</span>
                            @endswitch
                            {{($nilai->nilai_lengkap)?"":" (Nilai Belum Lengkap)"}}
                        </td>
                        <td class=""><p class="break-all max-w-lg">
                            {{$nilai->message}}
                            </p></td>

                    </tr>
                    @endforeach


                </tbody>
            </table>
            <div class="title">B. PENGETAHUAN DAN KETRAMPILAN</div>
            <table class="table table-condensed table-striped" style="border-collapse:collapse;">
                <thead class="thead-light">
                    <tr>
                        <th rowspan="2" class="align-middle">#</th>
                        <th rowspan="2" class="align-middle">Mata Pelajaran</th>
                        <th colspan="2" class="align-middle text-center">Pengetahuan</th>

                        <th colspan="2" class="align-middle text-center">Keterampilan</th>

                    </tr>
                    <tr>
                        <th class=" text-center">Nilai</th>
                        <th class=" text-center">Predikat</th>

                        <th class=" text-center">Nilai</th>
                        <th class=" text-center">Predikat</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($kds as $index => $kd)
                    <tr data-toggle="collapse" data-target="#demo{{$index+1}}" class="accordion-toggle cursor-pointer">
                        <td>{{$index+1}}</td>
                        <td>{{$kd['course']['name']}}</td>
                        <td>{{round($kd['nilai_akhir_3'])}}</td>
                        <td class="text-success">{{$kd['predikat_3']}}</td>
                        <td>{{round($kd['nilai_akhir_4'])}}</td>
                        <td class="text-success">{{$kd['predikat_4']}}</td>
                    </tr>
                    <tr>

                        <td colspan="2" class=" p-0" ></td>
                        <td colspan="2" class="hiddenRow p-0"> <div class="accordian-body collapse py-2 break-all max-w-sm" id="demo{{$index+1}}">{{$kd['message_3']}}</div></td>
                        <td colspan="2" class="hiddenRow p-0"> <div class="accordian-body collapse py-2 break-all max-w-sm" id="demo{{$index+1}}">{{$kd['message_4']}}</div></td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>



</div>

