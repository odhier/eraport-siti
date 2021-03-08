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
                        <div class="col-12 col-md-6 space-y-2 mb-3">
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
                            <div class="form-row">
                            <input type="hidden" wire:model="ekstrakurikuler.id">
                            @foreach($ekstrakurikuler['detail'] as $index => $value)
                            <div class="col-sm-4  mb-3">
                                <label for="sakit">Nama Kegiatan</label>
                                <div class="input-group">
                                    <input class="form-control" aria-label="With textarea" wire:model.defer="ekstrakurikuler.detail.{{$index}}.name" class="form-control is-valid">
                                </div>
                                @if(isset($validation_errors["$index.name"]))
                                    @foreach($validation_errors["$index.name"] as $k => $v)
                                    <label for="" class="text-danger">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-sm-2">
                                <label for="sakit">Nilai</label>
                                <div class="input-group">
                                    <input class="form-control" class="form-control is-valid" wire:model.defer="ekstrakurikuler.detail.{{$index}}.nilai">
                                </div>
                                @if(isset($validation_errors["$index.nilai"]))
                                    @foreach($validation_errors["$index.nilai"] as $k => $v)
                                    <label for="" class="text-danger">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-sm-6">
                                <label for="sakit">Keterangan</label>
                                <div class="input-group d-flex flex-row">
                                    <input class="form-control col-10" aria-label="With textarea" wire:model.defer="ekstrakurikuler.detail.{{$index}}.keterangan" class="form-control is-valid">
                                    <div class="col-2">
                                    @if(count($ekstrakurikuler['detail']) > 1)
                                    <a class="p-1 text-red-600 hover:text-red-800 rounded" wire:click="removeDetail({{$index}})">
                                        <i class="fas fa-times"></i>
                                    </a>
                                    @endif
                                    @if($index+1== count($ekstrakurikuler['detail']))
                                    <a class="p-1 text-blue-600 hover:text-blue-800 rounded" wire:click="addDetail">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    @endif
                                </div>
                                </div>
                                @if(isset($validation_errors["$index.keterangan"]))
                                    @foreach($validation_errors["$index.keterangan"] as $k => $v)
                                    <label for="" class="text-danger">{{ $v }}</label>
                                    @endforeach
                                @endif

                            </div>
                            @endforeach


                            </div>

                        </div>

                    </div>
                    @endif

                    <button class="toggleLoading" @click="isLoading = false" class="hidden"></button>
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

                            <button class="toggleSaving" @click="isSaving = false" class="hidden"></button>
                            <button  x-show="!isSaving" @click="isSaving = true" type="button" class="btn s-btn-primary my-3 btn-modal-save" wire:click="save">Submit</button>


                        </div>
                    </div>
                </div>
        </div>

    </div>
