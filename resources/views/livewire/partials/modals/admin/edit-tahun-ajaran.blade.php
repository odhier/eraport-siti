<div wire:ignore.self x-on:close-modal.window="on = false" class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="createUsersModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Edit {{ $subMenu }}</h4>
                <button type="button" wire:click="emptyForm" class="close" id="closeBtn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">


                <form wire:submit.prevent="create" class="form-modal">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="inputTahun">Tahun Ajaran<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="inputTahun" placeholder="Masukkan Tahun Ajaran Baru (ex: 2020/2021)" wire:model="tahun.tahun_ajaran">
                                @if(isset($validation_errors["tahun_ajaran"]))
                                @foreach($validation_errors["tahun_ajaran"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                                @endif
                            </div>
                        </div>


            </div>
            <div class=" w-100">
                <div class="row d-flex align-items-center">

                    <div class="col-12 text-right ">
                        <button wire:click="emptyForm" data-dismiss="modal" class="btn btn-default my-3">Cancel</button>
                        <button type="button" wire:click="update" class="btn s-btn-primary my-3 btn-modal-save">Submit</button>


                    </div>
                </div>
            </div>

        </div>


    </form>



            </div>
        </div>
    </div>
</div>

