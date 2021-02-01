<div wire:ignore.self x-on:close-modal.window="on = false" class="modal fade bd-example-modal-lg" id="assignNilaiModal" tabindex="-1" role="dialog" aria-labelledby="createUsersModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Edit {{ $subMenu }} KI-{{ $kode_ki }}</h4>
                <a wire:click="emptyForm" class="close cursor-pointer" id="closeBtn" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">×</span>
                </a>
            </div>
            <div class="modal-body">

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
                        @if(!$errors->has('kds.*.*'))

                            @foreach($kds as $index => $kd)
                            @php $nilai_akhir += $kd['value']!=""?$kd['value']:0 @endphp
                        @endforeach
                        @endif
                        @if(count($kds))
                        @php $nilai_akhir = round($nilai_akhir/count($kds)) @endphp
                        <div class="row">
                            <label class="col-sm-4 col-form-label py-0">Predikat</label>
                            <div class="col-sm-8 col-form-label py-0">
                                @switch($nilai_akhir)
                                    @case(1)
                                        <b>PB</b>
                                    @break
                                    @case(2)
                                        <b>MM</b>
                                    @break
                                    @case(3)
                                        <b>B</b>
                                    @break
                                    @case(4)
                                        <b>SB</b>
                                    @break
                                    @default
                                        <span>-</span>
                                @endswitch
                            </div>
                        </div>
                        @endif

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
                                <span class="input-group-text">{{$kd['ki']['kode']}}.{{$index+1}}</span>
                            </div>
                            <textarea class="form-control" aria-label="With textarea" id="kd-{{$index}}" rows="1" class="form-control is-valid" readonly>{{$kd['kompetensi']}}</textarea>
                        </div>
                    </div>
                    <div class="col-sm-5 offset-md-1">

                        <label for="kd-{{$index}}">Nilai</label>
                        <div class="input-group d-flex justify-content-between">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="nilai-{{$index}}" id="kd-{{$index}}-SB" value="4" wire:model="kds.{{$index}}.value">
                            <label class="form-check-label" for="inlineRadio1">SB</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="nilai-{{$index}}" id="kd-{{$index}}-B" value="3" wire:model="kds.{{$index}}.value">
                            <label class="form-check-label" for="inlineRadio2">B</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="nilai-{{$index}}" id="kd-{{$index}}-MM" value="2" wire:model="kds.{{$index}}.value">
                            <label class="form-check-label" for="inlineRadio3">MM</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="nilai-{{$index}}" id="kd-{{$index}}-PB" value="1" wire:model="kds.{{$index}}.value">
                            <label class="form-check-label" for="inlineRadio3">PB</label>
                          </div>
                        </div>
                        @error('kds.'.$index.'.value') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                </div>

                @endforeach

                <hr>
                <div class="row">
                    <div class="col-12">
                        <textarea class="form-control" id="validationTextarea" placeholder="Deskripsi" wire:model="deskripsi.deskripsi"></textarea>

                    </div>
                </div>
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
</div>

