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
                    <div class="col font-weight-bold">{{$course['id']}}</div>
                </div>
                <div class="row">
                    <div class="col">Nama Mata Pelajaran</div>
                    <div class="col font-weight-bold">{{$course['name']}}</div>
                </div>
                <div class="row">
                    <div class="col">Kode Mata Pelajaran</div>
                    <div class="col font-weight-bold">{{$course['kode']}}</div>
                </div>
                <div class="row">
                    <div class="col">Is Active</div>
                    @if($course['is_active'])
                        <div class="col font-weight-bold text-success">Active</div>
                    @else
                        <div class="col font-weight-bold text-danger">Non Active</div>
                    @endif

                </div>
            </div>
        </div>
            </div>
    </div>
</div>
</div>
</div>

