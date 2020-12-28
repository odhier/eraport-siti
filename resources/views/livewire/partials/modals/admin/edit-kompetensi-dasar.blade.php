<div wire:ignore.self x-on:close-modal.window="on = false" class="modal fade bd-example-modal-lg" id="kdmodal" tabindex="-1" role="dialog" aria-labelledby="createUsersModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Edit {{ $subMenu }} KI-{{ $current_ki }}</h4>
                <a type="button" wire:click="emptyForm" class="close" id="closeBtn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </a>
            </div>
            <div class="modal-body">
                @if($course)
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Mata Pelajaran</label>
                    <div class="col-sm-10 col-form-label">
                        <b>{{$course['name']}}</b>
                        @if(isset($validation_errors["tingkat_kelas"]))
                        @foreach($validation_errors["tingkat_kelas"] as $k => $v)
                        <label for="" class="text-danger">{{ $v }}</label>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="InputTingkat" class="col-sm-2 col-form-label">Tingkat Kelas<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select class="form-control" id="InputTingkat" wire:model="data.tingkat_kelas" wire:change="changeParam()" style="width: 200px">
                            @foreach ($allTingkat as $tingkat)
                            <option value="{{$tingkat}}" wire:key="{{$tingkat}}">{{$tingkat}}</option>
                            @endforeach
                        </select>
                        @if(isset($validation_errors["tingkat_kelas"]))
                        @foreach($validation_errors["tingkat_kelas"] as $k => $v)
                        <label for="" class="text-danger">{{ $v }}</label>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                            <label for="inputState" class="col-sm-2 col-form-label">Tahun Ajaran<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select id="inputState" class="form-control" wire:model="data.tahun_ajaran_id" wire:change="changeParam()" style="width: 200px">
                                    <option value="" selected>Pilih Tahun Ajaran</option>
                                    @foreach ($allTahun as $tahun)
                                    <option value="{{$tahun['id']}}" wire:key="{{$tahun['id']}}">{{$tahun['tahun_ajaran']}}</option>
                                    @endforeach
                                </select>
                                @if(isset($validation_errors["tahun_ajaran_id"]))
                                @foreach($validation_errors["tahun_ajaran_id"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                                @endif
                            </div>

                    </div>

                <div class="form-group row">
                            <label for="inputState" class="col-sm-2 col-form-label">KKM</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @if($data['kkm']['value']) is-valid @endif @error('data.kkm.value') is-invalid @enderror" id="kkm" wire:model.debounce.500ms="data.kkm.value" style="max-width: 100px">
                                @error('data.kkm.value') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                </div>

                <hr>
                <div class="form-group row">
                    <label for="inputKd" class="col-12 col-form-label">Kompetensi Dasar</label>
                    <div class="col-12">
                        @foreach ($kds as $index=>$kd)
                        <div class="d-flex flex-row space-x-3 mb-3">
                            <input type="hidden" wire:model="kds.{{$index}}.id">
                            <span class="col-form-label">{{$index+1}}.</span>
                            <input type="text" class="form-control col-10" id="inputKd-{{$index+1}}" wire:model="kds.{{$index}}.value" wire:keydown.enter="addKD">
                            @if(count($kds) > 1)
                            <a wire:click="removeKD({{$index}}, {{(isset($kds[$index]['id']))?$kds[$index]['id']:0}})" class="p-1 text-red-600 hover:text-red-800 rounded">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                            @if($index+1== count($kds))
                            <a wire:click="addKD" class="p-1 text-blue-600 hover:text-blue-800 rounded">
                                <i class="fas fa-plus"></i>
                            </a>
                            @endif
                        </div>
                        @endforeach
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
                            <a type="button" wire:click="save" class="btn s-btn-primary my-3 btn-modal-save">Save</a>


                        </div>
                    </div>
                </div>
                @else
                <h2>Oops, mata pelajaran tidak ditemukan</h2>
                @endif
            </div>
        </div>
    </div>
</div>

