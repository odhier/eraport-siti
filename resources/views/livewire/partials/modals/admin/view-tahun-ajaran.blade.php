<div wire:ignore.self x-on:close-modal.window="on = false" class="modal fade bd-example-modal-lg" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="createUsersModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">View {{ $subMenu }}</h4>
                <button type="button" class="close" wire:click="emptyForm" id="closeBtn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        <div class="modal-body ">
            <div class="container p-3">
                <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col">ID</div>
                    <div class="col font-weight-bold">{{$tahun['id']}}</div>
                </div>
                <div class="row">
                    <div class="col">Tahun Ajaran</div>
                <div class="col font-weight-bold">{{$tahun['tahun_ajaran']}}</div>
                </div>


            </div>
        </div>
            </div>
    </div>
</div>
</div>
</div>

