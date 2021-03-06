<div wire:ignore.self x-on:close-modal.window="on = false" class="modal fade bd-example-modal-lg" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createUsersModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Create {{ $subMenu }}</h4>
                <button type="button" class="close" wire:click="emptyForm" id="closeBtn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="create" class="form-modal">
                    <div class="row">

                        <div class="col-12">
                            <div class="form-group">
                                <label for="inputKode">Kode<span class="text-danger">*</span></label>
                                <input type="text" wire:keydown.enter="create" class="form-control" id="inputKode" placeholder="Masukkan Kode KI" wire:model="ki.kode">
                                @if(isset($validation_errors["kode"]))
                                @foreach($validation_errors["kode"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="inputName">Nama Kompetensi<span class="text-danger">*</span></label>
                                <input type="name" wire:keydown.enter="create" class="form-control" id="inputName" placeholder="Masukkan Nama Kompetensi" wire:model="ki.name">
                                @if(isset($validation_errors["name"]))
                                @foreach($validation_errors["name"] as $k => $v)
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
                        <a wire:click="create" class="btn s-btn-primary my-3 btn-modal-save">Submit</a>


                    </div>
                </div>
            </div>

        </div>


    </form>
            </div>
        </div>
    </div>
</div>

