<div wire:ignore.self x-on:close-modal.window="on = false" class="modal fade bd-example-modal-lg" id="kimodal" tabindex="-1" role="dialog" aria-labelledby="createUsersModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Edit {{ $subMenu }} KI-{{ $current_ki['kode'] }}</h4>
                <a type="button" wire:click="emptyForm" class="close" id="closeBtn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Kompetensi Inti</label>
                    <div class="col-sm-8 col-form-label">
                        <b>{{$current_ki['name']}}</b>

                    </div>
                </div>


                <hr>
                <div class="form-group row">
                    <label for="inputKd" class="col-12 col-form-label">Kompetensi</label>
                    <div class="col-12">
                        @foreach ($all_ki as $index=>$kd)
                        <div class="d-flex flex-row space-x-3 mb-3">
                            <input type="hidden" wire:model="all_ki.{{$index}}.id">
                            <span class="col-form-label">{{$index+1}}.</span>
                            <input type="text" class="form-control col-10" id="inputKi-{{$index+1}}" wire:model="all_ki.{{$index}}.kompetensi" wire:keydown.enter="addKD">
                            @if(count($all_ki) > 1)
                            <a wire:click="removeKI({{$index}}, {{(isset($all_ki[$index]['id']))?$all_ki[$index]['id']:0}})" class="p-1 text-red-600 hover:text-red-800 rounded">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                            @if($index+1== count($all_ki))
                            <a wire:click="addKI" class="p-1 text-blue-600 hover:text-blue-800 rounded">
                                <i class="fas fa-plus"></i>
                            </a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class=" w-100">
                    <div class="row d-flex align-items-center">

                        <div class="col-12 text-right ">
                            <a wire:click="emptyForm" data-dismiss="modal" class="btn btn-default my-3">Cancel</a>
                            <a type="button" wire:click="save" class="btn s-btn-primary my-3 btn-modal-save">Save</a>


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

