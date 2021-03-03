<div wire:ignore.self x-on:close-modal.window="on = false" class="modal fade bd-example-modal-lg" id="appointModal" tabindex="-1" role="dialog" aria-labelledby="createUsersModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Pilih Kelas</h4>
                <a type="button" class="close" wire:click="emptyForm" id="closeBtn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </a>
            </div>
            <div class="modal-body">
                <form class="form-modal" onsubmit="return false;">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">

                                @livewire('partials.class-search-bar')
                                @if(isset($validation_errors["class_id"]))
                                @foreach($validation_errors["class_id"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="inputState">Tahun Ajaran<span class="text-danger">*</span></label>
                                <select id="inputState" class="form-control" wire:model="SClass.tahun_ajaran_id">
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

            </div>
            <div class="s-modal-footer w-100">
                <div class="row d-flex align-items-center">

                    <div class="col-12 text-right ">
                        <a wire:click="emptyForm" data-dismiss="modal" class="btn btn-default my-3">Cancel</a>
                        @if($SClass['class_id'] && $SClass['tahun_ajaran_id'])
                        <span class="m-0 p-0" wire:click="$set('savingAppoint', true)">
                            <a wire:click="$emitTo('admin-students-table', 'appoint', {{$SClass['class_id']}}, {{$SClass['tahun_ajaran_id']}})" class="btn s-btn-primary my-3 btn-modal-save">Submit</a>
                        </span>
                        @else
                        <a disabled class="btn s-btn-primary bg-green-100 my-3 btn-modal-save bg-green-100 disabled">Submit</a>
                        @endif

                    </div>
                </div>
            </div>

        </div>


    </form>
            </div>
        </div>
        <div class="{{$savingAppoint?'block':'hidden'}}">
            <div id="loadingStatement">
                <div class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-700 opacity-75 flex flex-col items-center justify-center">
                    <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
                    <h2 class="text-center text-white text-xl font-semibold">Saving...</h2>
                    <p class="w-1/3 text-center text-white">This may take a few seconds, please don't close this page.</p>
                </div>
        </div>
    </div>

</div>

