<div class="modal-dialog modal-lg">
<div class="modal-content" x-data="{isLoading : true}">
        <div class="modal-header">
            <h5 class="modal-title">Fisik & Kondisi Kesehatan</h5>
            <button type="button" @click="isLoading=true" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
            <div class="modal-body">
                <div x-show="isLoading">
                    <div class="row">
                    <div class="col-12 col-md-6 space-y-2">
                        <div class="row">
                            <label class="col-sm-4 col-form-label py-0">Siswa</label>
                            <div class="col-sm-8 col-form-label py-0">
                                <div class="h-4 bg-gray-400 rounded w-2/6 animate-pulse"></div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label py-0">Semester</label>
                            <div class="col-sm-8 col-form-label py-0">
                                <div class="h-4 bg-gray-400 rounded w-5/6 animate-pulse"></div>
                            </div>
                        </div>

                    </div>
                </div>

                    <hr>
                    <div class="animate-pulse flex space-x-4">

                        <div class="flex-1 space-y-4 py-1">
                            <div class="space-y-2">
                                <div class="h-4 bg-gray-400 rounded w-1/6"></div>
                                <div class="h-4 bg-gray-400 rounded w-5/6"></div>
                            </div>
                        </div>
                        <hr>
                        <div class="flex-1 space-y-4 py-1">
                            <div class="space-y-2">
                                <div class="h-4 bg-gray-400 rounded w-1/6"></div>
                                <div class="h-4 bg-gray-400 rounded w-5/6"></div>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="animate-pulse flex space-x-4">

                        <div class="flex-1 space-y-4 py-1">
                            <div class="space-y-2">
                                <div class="h-4 bg-gray-400 rounded w-1/6"></div>
                                <div class="h-4 bg-gray-400 rounded w-5/6"></div>
                            </div>
                        </div>
                        <div class="flex-1 space-y-4 py-1">
                            <div class="space-y-2">
                                <div class="h-4 bg-gray-400 rounded w-1/6"></div>
                                <div class="h-4 bg-gray-400 rounded w-5/6"></div>
                            </div>
                        </div>
                        <div class="flex-1 space-y-4 py-1">
                            <div class="space-y-2">
                                <div class="h-4 bg-gray-400 rounded w-1/6"></div>
                                <div class="h-4 bg-gray-400 rounded w-5/6"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($student_class)
                <div class="row" x-show="!isLoading">
                    <div class="col-12 col-md-6 space-y-2">
                        <div class="row">
                            <label class="col-sm-4 col-form-label py-0">Siswa</label>
                            <div class="col-sm-8 col-form-label py-0">
                                <h5><b>{{$student_class->student->name}}</b></h5>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label py-0">Semester</label>
                            <div class="col-sm-8 col-form-label py-0">
                                <b>{{$semester['id']}} / {{$semester['name']}}</b>
                            </div>
                        </div>

                    </div>

                    <div class="col-12 space-x-2">
                        <hr>
                        <div class="form-row mb-3">
                        <input type="hidden" wire:model="physique.id">
                        <div class="col-sm-6">
                            <label for="sakit">Tinggi</label>
                            <div class="input-group">
                                <input class="form-control" aria-label="With textarea" id="tinggi" rows="1" class="form-control is-valid" wire:model.defer="physique.tinggi" aria-describedby="basic-addon">
                                <span class="input-group-text" id="basic-addon">Cm</span>
                            </div>
                            @if(isset($validation_errors["tinggi"]))
                                @foreach($validation_errors["tinggi"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <label for="izin">Berat Badan</label>
                            <div class="input-group">
                                <input class="form-control" aria-label="With textarea" id="berat" rows="1" class="form-control is-valid" wire:model.defer="physique.berat" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">Kg</span>
                            </div>
                            @if(isset($validation_errors["berat"]))
                                @foreach($validation_errors["berat"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                            @endif
                        </div>

                        </div>
                    </div>
                    <div class="col-12 space-x-2">
                        <hr>
                        <div class="form-row mb-3">
                        <input type="hidden" wire:model="physique.id">
                        <div class="col-sm-4">
                            <label for="sakit">Pendengaran</label>
                            <div class="input-group">
                                <select wire:model.defer="physique.pendengaran" class="form-select p-2 active:outline-none focus:outline-none border border-gray-700 rounded" aria-label="Default select example" id="pendengaran">
                                    <option selected wire:key="" value="">Pilih kondisi pendengaran</option>
                                    <option wire:key="Baik" value="Baik">Baik</option>
                                    <option wire:key="Tidak Baik" value="Tidak Baik">Tidak Baik</option>
                                  </select>
                            </div>
                            @if(isset($validation_errors["pendengaran"]))
                                @foreach($validation_errors["pendengaran"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-sm-4">
                            <label for="izin">Penglihatan</label>
                            <div class="input-group">
                                <select wire:model.defer="physique.penglihatan" class="form-select p-2 active:outline-none focus:outline-none border border-gray-700 rounded" aria-label="Default select example" id="penglihatan">
                                    <option selected wire:key="" value="">Pilih kondisi penglihatan</option>
                                    <option wire:key="Baik" value="Baik">Baik</option>
                                    <option wire:key="Tidak Baik" value="Tidak Baik">Tidak Baik</option>
                                  </select>
                            </div>
                            @if(isset($validation_errors["penglihatan"]))
                                @foreach($validation_errors["penglihatan"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-sm-4">
                            <label for="izin">Gigi</label>
                            <div class="input-group">
                                <select wire:model.defer="physique.gigi" class="form-select p-2 active:outline-none focus:outline-none border border-gray-700 rounded" aria-label="Default select example" id="gigi">
                                    <option selected wire:key="" value="">Pilih kondisi gigi</option>
                                    <option wire:key="Bersih" value="Bersih">Bersih</option>
                                    <option wire:key="Tidak Bersih" value="Tidak Bersih">Tidak bersih</option>
                                  </select>
                            </div>
                            @if(isset($validation_errors["gigi"]))
                                @foreach($validation_errors["gigi"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                            @endif
                        </div>

                        </div>
                    </div>

                </div>
                @endif

                <button id="togglePhysiqueLoading" @click="isLoading = false" class="hidden">-</button>
            </div>
            <div class="modal-footer" x-data="{isSaving: false}">
                <div class="row d-flex align-items-center">

                    <div class="col-12 text-right ">
                        <button data-dismiss="modal" id="close-btn-modal" @click="isLoading=true" class="btn btn-default my-3">Cancel</button>

                        <button disabled="" x-show="isSaving" type="button" class="disabled my-3 opacity-50 align-middle bg-teal-500 cursor-wait inline-flex items-center px-2 border border-teal-400 rounded-md text-white focus:outline-none">
                            <svg class="animate-spin m-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                              </svg>
                              <span class="sm:hidden md:block">Saving</span>
                        </button>

                        <button id="togglePhysiqueSaving" @click="isSaving = false" class="hidden">-</button>
                        <button  x-show="!isSaving" @click="isSaving = true" type="button" class="btn s-btn-primary my-3 btn-modal-save" wire:click="save">Submit</button>


                    </div>
                </div>
            </div>
    </div>

</div>
