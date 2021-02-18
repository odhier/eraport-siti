<div wire:ignore.self x-on:close-modal.window="on = false" class="modal fade bd-example-modal-lg" id="assignNilaiModal" tabindex="-1" role="dialog" aria-labelledby="createUsersModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Edit {{ $subMenu }} KI-{{ $current_ki }}</h4>
                <a wire:click="emptyForm" class="close cursor-pointer" id="closeBtn" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">×</span>
                </a>
            </div>
            <div class="modal-body" wire:loading wire:target="editForm">
                <h5 class="animate-bounce">Loading Data...</h5>
                <div class="animate-pulse flex space-x-4">

                    <div class="flex-1 space-y-4 py-1">
                      <div class="h-4 bg-gray-400 rounded w-3/4"></div>
                      <div class="space-y-2">
                        <div class="h-4 bg-gray-400 rounded"></div>
                        <div class="h-4 bg-gray-400 rounded w-5/6"></div>
                      </div>
                    </div>
                  </div>
            </div>
            <div class="modal-body" wire:loading.remove wire:target="editForm">

                @if($student_class)
                <div class="row">
                    <div class="col-12 col-md-6 space-y-2">
                        <div class="row">
                            <label class="col-sm-4 col-form-label py-0">Siswa</label>
                            <div class="col-sm-8 col-form-label py-0">
                                <h5><b>{{$student_class['student']['name']}}</b></h5>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label py-0">Kelas / Semester</label>
                            <div class="col-sm-8 col-form-label py-0">
                                <b>{{$student_class['classes']['tingkat']}} ({{$student_class['classes']['name']}}) {{$selected_semester_name}}</b>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label py-0">Tahun Ajaran</label>
                            <div class="col-sm-8 col-form-label py-0">
                                <b>{{$student_class['tahun_ajaran']['tahun_ajaran']}}</b>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 space-y-2">
                        <div class="row justify-content-end">
                            <label class="col-sm-6 col-form-label py-0 text-right">KKM</label>
                            <div class="col-3 col-form-label py-0">
                                <b>{{$kkm}}</b>
                            </div>
                        </div>
                        <div class="row justify-content-end">

                            @if(!$errors->has('kds.*.*'))
                            @foreach($kds as $index => $kd)

                            @php $nilai_akhir += (
                                (
                                (($kd['NH']!=""?$kd['NH']:0)*2) + ($kd['NUTS']!=""?$kd['NUTS']:0) + ($kd['NUAS']!=""?$kd['NUAS']:0)
                                )/4
                                )
                            @endphp
                            @endforeach

                            @php
                            $nilai_akhir = $nilai_akhir?round($nilai_akhir/count($kds),2):0;

                            $nilai_akhir_r = round($nilai_akhir);
                            $predikat = ($nilai_akhir_r>=93)?"A":(($nilai_akhir_r>=86)?"B":(($nilai_akhir_r>=80)?"C":"D"));
                            @endphp
                            @else
                            @php
                            $nilai_akhir = "-";
                            $nilai_akhir_r = "-";
                            $predikat = "-"
                            @endphp
                            @endif
                            <label class="col-sm-6 col-form-label py-0 text-right">Nilai Akhir (Rounded)</label>
                            <div class="col-3 col-form-label py-0">
                                <b>{{$nilai_akhir}} ({{$nilai_akhir_r}})</b>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <label class="col-sm-6 col-form-label py-0 text-right">Predikat</label>
                            <div class="col-3 col-form-label py-0">
                                <b>{{$predikat}}</b>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                @if($kds)
                @foreach ($kds as $index => $kd)
                <div class="form-row mb-3">
                    <div class="col-sm-4">
                        <label for="kd-{{$index}}">Kompetensi Dasar</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{$current_ki}}.{{$index+1}}</span>
                            </div>
                            <textarea class="form-control" aria-label="With textarea" id="kd-{{$index}}" rows="1" class="form-control is-valid" readonly>{{$kd['value']}}</textarea>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label for="nh-{{$index+1}}">Nilai Harian</label>
                        <input type="text" class="form-control @if($kds[$index]['NH']) is-valid @endif @error('kds.'.$index.'.NH') is-invalid @enderror" id="nh-{{$index+1}}" wire:model="kds.{{$index}}.NH">
                        @error('kds.'.$index.'.NH') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-sm-2">
                        <label for="nakd-{{$index+1}}">Nilai UTS</label>
                        <input type="text" class="form-control @if($kds[$index]['NUTS']) is-valid @endif @error('kds.'.$index.'.NUTS') is-invalid @enderror" id="nuts-{{$index+1}}" wire:model="kds.{{$index}}.NUTS">
                        @error('kds.'.$index.'.NUTS') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-sm-2">
                        <label for="nuas-{{$index+1}}">Nilai UAS</label>
                        <input type="text" class="form-control @if($kds[$index]['NUAS']) is-valid @endif @error('kds.'.$index.'.NUAS') is-invalid @enderror" id="nuas-{{$index+1}}" wire:model="kds.{{$index}}.NUAS">
                        @error('kds.'.$index.'.NUAS') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-sm-2">
                        <label for="nakd-{{$index+1}}">Nilai Akhir KD</label>
                        <a class="s-tooltip"><i class="fas fa-question-circle" ></i>
                            <div class="s-tooltip-text bg-black text-white text-xs rounded py-1 px-4 right-0 bottom-full">
                                ((2xNH)+NUTS+NUAS) / 4
                                <svg class="absolute text-black h-2 left-0 ml-3 top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve"><polygon class="fill-current" points="0,0 127.5,127.5 255,0"/></svg>
                            </div>
                        </a>
                        @if(!$errors->has('kds.*.*'))
                        @php $nakd[$index] = ceil(
                        (
                        (($kds[$index]['NH']!=""?$kds[$index]['NH']:0)*2) + ($kds[$index]['NUTS']!=""?$kds[$index]['NUTS']:0) + ($kds[$index]['NUAS']!=""?$kds[$index]['NUAS']:0)
                        )/4
                        )

                        @endphp
                        @else
                        @php $nakd[$index] = "-"; @endphp
                        @endif
                        <input type="text" class="form-control" id="nakd-{{$index+1}}" value="{{$nakd[$index]}}" readonly>
                    </div>
                </div>

                @endforeach

                <hr>
                @if(strtoupper($course->course->kode) == "UMMI")
                <div class="row">
                    <div class="col-12">
                        <textarea class="form-control" id="validationTextarea" placeholder="Deskripsi" wire:model="deskripsi.deskripsi"></textarea>

                    </div>
                </div>

                @endif

                <div class=" w-100">
                    <div class="row d-flex align-items-center">
                        <div class="col-6 d-flex align-items-center">
                            <input type="checkbox" class="toggle" checked id="inputMore" wire:model="inputMore">
                            <label for="inputMore" class="my-auto ml-3">Jangan tutup form setelah selesai</label>
                        </div>
                        <div class="col-6 text-right ">
                            <a wire:click="emptyForm" data-dismiss="modal" class="btn btn-default my-3">Cancel</a>
                            <a wire:click="save" class="btn s-btn-primary my-3 btn-modal-save">Save</a>


                        </div>
                    </div>
                </div>
                @else
                <h5 class="text-center p-3">Kompetensi Dasar belum dibuat untuk Pelajaran, Kelas, dan Tahun ajaran ini. silahkan hubungi admin untuk menginput Kompetensi Dasar</h5>
                @endif
                @else
                <h2>Oops, mata pelajaran tidak ditemukan</h2>
                @endif
                </.>
            </div>
        </div>
    </div>

