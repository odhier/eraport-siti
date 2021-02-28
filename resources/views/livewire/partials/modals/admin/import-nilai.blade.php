<div wire:ignore.self x-on:close-modal.window="on = false" class="modal fade bd-example-modal-sm" id="importModal" tabindex="-1" role="dialog" aria-labelledby="createUsersModal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Import Nilai</h4>
                <a wire:click="emptyForm" class="close cursor-pointer" id="closeBtn" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">×</span>
                </a>
            </div>
            <div class="modal-body" wire:loading.remove wire:target="editForm">
                <form wire:submit.prevent="import" class="form-modal">
                <div class="form-group">
                    <label for="exampleFormControlFile1">File Excel</label>
                    <input type="file" class="form-control-file" id="excel" required wire:model="excel">
                    @if(isset($validation_errors["excel"]))
                                @foreach($validation_errors["excel"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                                @endif
                </div>
                <div class="s-modal-footer w-100">
                    <div class="row d-flex align-items-center">

                        <div class="col-12 text-right ">
                            <button data-dismiss="modal" class="btn btn-default my-3">Cancel</button>

                            <button wire:target="import" wire:loading.attr="disabled" type="button" wire:click="import" class="btn s-btn-primary my-3 btn-modal-save">
                                <i wire:target="import" wire:loading >Saving...</i>
                                <span wire:target="import" wire:loading.remove >Import</span>
                            </button>


                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:loading>
    <div id="loadingStatement">
        <div class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-700 opacity-75 flex flex-col items-center justify-center">
            <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
            <h2 class="text-center text-white text-xl font-semibold">Uploading File...</h2>
            <p class="w-1/3 text-center text-white">This may take a few seconds, please don't close this page.</p>
        </div>
    </div>
</div>
</div>


