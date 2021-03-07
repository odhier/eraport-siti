<div wire:ignore.self x-on:close-modal.window="on = false" class="modal fade bd-example-modal-lg" id="assignAbsensi" tabindex="-1" role="dialog" aria-labelledby="createUsersModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Absensi & Saran</h4>
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


                    </div>

                </div>
                <hr>

                <div class="form-row mb-3">
                    <input type="hidden" wire:model="absensi.id">
                <div class="col-sm-4">
                    <label for="sakit">Sakit</label>
                    <div class="input-group">
                        <input class="form-control" aria-label="With textarea" id="sakit" rows="1" class="form-control is-valid" wire:model="absensi.sakit"></input>
                    </div>
                    @if(isset($validation_errors["sakit"]))
                        @foreach($validation_errors["sakit"] as $k => $v)
                        <label for="" class="text-danger">{{ $v }}</label>
                        @endforeach
                    @endif
                </div>
                <div class="col-sm-4">
                    <label for="izin">Izin</label>
                    <div class="input-group">
                        <input class="form-control" aria-label="With textarea" id="izin" rows="1" class="form-control is-valid" wire:model="absensi.izin"></input>
                    </div>
                    @if(isset($validation_errors["izin"]))
                        @foreach($validation_errors["izin"] as $k => $v)
                        <label for="" class="text-danger">{{ $v }}</label>
                        @endforeach
                    @endif
                </div>
                <div class="col-sm-4">
                    <label for="tanpa_keterangan">Tanpa Keterangan</label>
                    <div class="input-group">
                        <input class="form-control" aria-label="With textarea" id="tanpa_keterangan" rows="1" class="form-control is-valid" wire:model="absensi.tanpa_keterangan"></input>
                    </div>
                    @if(isset($validation_errors["tanpa_keterangan"]))
                        @foreach($validation_errors["tanpa_keterangan"] as $k => $v)
                        <label for="" class="text-danger">{{ $v }}</label>
                        @endforeach
                    @endif
                </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <input type="hidden" wire:model="saran.id">
                        <textarea class="form-control" id="validationTextarea" placeholder="Saran" wire:model="saran.saran"></textarea>

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
                            <a wire:click="saveAbsensi" class="btn s-btn-primary my-3 btn-modal-save">Save</a>


                        </div>
                    </div>
                </div>

                @else
                <h2>Oops, mata pelajaran tidak ditemukan</h2>
                @endif
                </.>
            </div>
        </div>
    </div>

