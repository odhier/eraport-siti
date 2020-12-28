<div wire:ignore.self x-on:close-modal.window="on = false" class="modal fade bd-example-modal-lg" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createUsersModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Create {{ $subMenu }}</h4>
                <a type="button" class="close" wire:click="emptyForm" id="closeBtn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </a>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="create" class="form-modal" onsubmit="return false;">
                    <div class="row">

                        <div class="col-12">
                            @livewire('partials.teacher-search-bar')
                            @if(isset($validation_errors["teacher_id"]))
                            @foreach($validation_errors["teacher_id"] as $k => $v)
                            <label for="" class="text-danger">{{ $v }}</label>
                            @endforeach
                            @endif
                        </div>
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
                                <select id="inputState" class="form-control" wire:model="wali_kelas.tahun_ajaran_id">
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
                    <div class="col-6 d-flex align-items-center">
                        <input type="checkbox" class="toggle" checked id="inputMore" wire:model="inputMore">
                        <label for="inputMore" class="my-auto ml-3">Jangan tutup form setelah selesai</label>
                    </div>
                    <div class="col-6 text-right ">
                        <a wire:click="emptyForm" data-dismiss="modal" class="btn btn-default my-3">Cancel</a>
                        <button type="button" wire:click="create" class="btn s-btn-primary my-3 btn-modal-save">Submit</button>


                    </div>
                </div>
            </div>

        </div>


    </form>
            </div>
        </div>
    </div>
</div>

