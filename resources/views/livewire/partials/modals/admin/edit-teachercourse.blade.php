<div wire:ignore.self x-on:close-modal.window="on = false" class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="createUsersModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Edit {{ $subMenu }}</h4>
                <a type="button" wire:click="emptyForm" class="close" id="closeBtn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </a>
            </div>
            <div class="modal-body">


                <form wire:submit.prevent="create" class="form-modal">
                    <div class="row">
                        <div class="col-12">
                            @livewire('partials.course-search-bar')
                            @if(isset($validation_errors["course_id"]))
                            @foreach($validation_errors["course_id"] as $k => $v)
                            <label for="" class="text-danger">{{ $v }}</label>
                            @endforeach
                            @endif
                        </div>
                        <div class="col-12">
                            @livewire('partials.teacher-search-bar')
                            @if(isset($validation_errors["user_id"]))
                            @foreach($validation_errors["user_id"] as $k => $v)
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
                                <select id="inputState" class="form-control" wire:model="teacher_course.tahun_ajaran_id">
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
            <div class=" w-100">
                <div class="row d-flex align-items-center">

                    <div class="col-12 text-right ">
                        <a wire:click="emptyForm" data-dismiss="modal" class="btn btn-default my-3">Cancel</a>
                        <a type="button" wire:click="update" class="btn s-btn-primary my-3 btn-modal-save">Submit</a>


                    </div>
                </div>
            </div>

        </div>


    </form>



            </div>
        </div>
    </div>
</div>

